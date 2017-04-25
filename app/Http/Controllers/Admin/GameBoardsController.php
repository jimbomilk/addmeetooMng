<?php namespace App\Http\Controllers\Admin;

use App\Events\ScreenEvent;
use App\General;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Gameboard;
use App\GameboardOption;
use App\Activity;
use App\ActivityOption;
use App\GameView;
use App\Http\Requests\GameboardRequest;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;





class GameboardsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');

    }

    public function sendView ($element=null)
    {
        $locations = Auth::user()->locations()->lists('name','id');
        $activities = Activity::all()->pluck('name','id');
        $progression = General::getEnumValues('gameboards','progression_type') ;

        if (isset($element)) {
            $element->starttime = $element->localStarttime;
            return view('admin.common.edit', ['name' => 'gameboards', 'element' => $element, 'statuses' => Status::$desc, 'locations' => $locations, 'activities' => $activities, 'progression' => $progression]);
        }
        else
            return view('admin.common.create',['name'=>'gameboards','statuses'=>Status::$desc,'locations'=>$locations,'activities'=>$activities,'progression'=>$progression]);
    }

    public function index()
	{
        if (Auth::user()->is('admin'))
            $gameboards = Gameboard::paginate();
        else
            $gameboards = Auth::user()->gameboards()->paginate();

        return view ('admin.common.index',['name'=>'gameboards','set'=>$gameboards,'statuses'=>Status::$desc,'colours'=>Status::$colors]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return $this->sendView();
    }



    public function store(GameboardRequest $request)
    {
        // Cuando creamos un gameboard, tenemos que crear tb todas sus opciones (copia de la actividad)
        $gameboard = new Gameboard($request->all());
        $gameboard->starttime = $gameboard->getUTCStarttime();
        $gameboard->createGame();

        return redirect()->route($this->indexPage("gameboards"));
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request,$id)
	{
        $game = Gameboard::findOrFail($id);

        if (isset ($game))
        {
            //$options = $game->gameboardOptions()->paginate();
            $request->session()->put('gameboard_id',$id);

            return redirect()->route($this->indexPage("gameboard_options"));

            //return view('admin.common.index',['name'=>'gameboard_options','set' => $options,'hide_new'=>$game->auto]);
        }
	}

    public  function preview($id)
    {
        $game = Gameboard::findOrFail($id);

        if (isset ($game)) {
            //Reiniciamos sus vistas
            if ($game->status == Status::SCHEDULED)
                $game->createGameViews();
            else
                $game->updateGameView();

            $gameview = $game->getGameView();

            if (isset($gameview)) {
                event(new ScreenEvent($gameview, 'location' . $game->location->id));

                $message = $game->name . ' sent preview';
                Session::flash('message', $message);
            }
            else
            {
                $message = 'ERROR: '.$game->name . ' no tiene ninguna vista creada!';
                Session::flash('message', $message);
            }
        }
        return redirect()->route($this->indexPage("gameboards"));
    }
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $gameboard = Gameboard::findOrFail($id);

        if (isset($gameboard))
        {
            return $this->sendView($gameboard);
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update(GameboardRequest $request, $id)
    {
        $this->gameboard = Gameboard::findOrFail($id);
        $currentstatus = $this->gameboard->status;
        $this->gameboard->fill($request->all());

        // Transformation as we always save UTC in BBDD
        $this->gameboard->starttime = $this->gameboard->getUTCStarttime();
        $this->gameboard->save();

        if ($currentstatus != $this->gameboard->status && $this->gameboard->status == Status::OFFICIAL )
        {
            $this->gameboard->publish();
        }

        return redirect()->route($this->indexPage("gameboards"));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
    {
        $gameboard = Gameboard::findOrFail($id);

        File::deleteDirectory(storage_path('app/public/').$gameboard->path);

        $gameboard->delete();
        $message = $gameboard->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Gameboard::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("gameboards"));
    }


    public function fastUpdate($id)
    {

        $column_name = Input::get('name');
        $column_value = Input::get('value');
        Log::info('col:'.$column_name.' , val:'.$column_value);

        if( Input::has('name') && Input::has('value')) {
            /*$game = Gameboard::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);*/
            $this->updateGame($id,$column_name,$column_value);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function updateGame($id,$column_name,$column_value)
    {
        $gameboard = Gameboard::findOrFail($id);
        if (isset($gameboard))
        {
            $gameboard->$column_name = $column_value;
            $gameboard->save();

            // Dependiendo del campo modificado tenemos que hacer diferentes acciones
            if ($column_name == 'status' && $column_value == Status::OFFICIAL)
                $gameboard->calculateRankings();


        }
    }
}

