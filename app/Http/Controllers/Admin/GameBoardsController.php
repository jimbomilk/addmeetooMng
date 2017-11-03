<?php namespace App\Http\Controllers\Admin;

use App\General;
use App\Http\Controllers\Controller;
use App\Jobs\GameEngine;
use App\UserGameboard;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Gameboard;
use App\Activity;
use App\Http\Requests\GameboardRequest;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


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

        $statuses = Auth::user()->statuses();
        if (isset($element)) {
            $element->startgame = $element->localStartgame;
            $element->endgame = $element->localEndgame;
            $element->deadline = $element->localDeadline;
            return view('admin.common.edit', ['name' => 'gameboards', 'element' => $element, 'statuses' => $statuses, 'locations' => $locations, 'activities' => $activities, 'progression' => $progression]);
        }
        else
            return view('admin.common.create',['name'=>'gameboards','statuses'=>$statuses,'locations'=>$locations,'activities'=>$activities,'progression'=>$progression]);
    }

    public function index()
	{
        $statuses = Auth::user()->statuses();
        if (Auth::user()->is('admin'))
            $gameboards = Gameboard::where('status','<',Status::HIDDEN)->orderby('deadline')->paginate();
        else
            $gameboards = Auth::user()->gameboards()->where('status','<',Status::HIDDEN)->orderby('deadline')->paginate();

        return view ('admin.common.index',['name'=>'gameboards','set'=>$gameboards,'statuses'=>$statuses,'colours'=>Status::$colors]);
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
        $gameboard->startgame = $gameboard->getUTCStartgame();
        $gameboard->endgame = $gameboard->getUTCEndgame();
        $gameboard->deadline = $gameboard->getUTCDeadline();

        $filename = $request->saveFile('image',$gameboard->path);
        if ($filename != $gameboard->image) {
            $gameboard->image = $filename;
        }

        $filename2 = $request->saveFile('imagebig',$gameboard->path);
        if ($filename2 != $gameboard->imagebig) {
            $gameboard->imagebig = $filename2;
        }

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


    public  function participants($id)
    {
        $options = null;
        $serie = null;
        $values = null;

        $participants = UserGameboard::getParticipation($id,$serie,$values);
        if (isset ($game)) {

            return view ('admin.gameboards.participants',['name'=>'participants','set'=>$participants,'options'=>$options]);

        }
    }

    public  function preview($id)
    {
        $game = Gameboard::findOrFail($id);

        if (isset ($game))
        {

            if ($game->status < Status::SCHEDULED){
                $message = 'ERROR: '.$game->name . ' no está configurado!';
                Session::flash('message', $message);
                return false;
            }
            //Reiniciamos sus vistas
            $gameview = $game->updateGameView();

            if (isset($gameview)) {

                $job = (new GameEngine($gameview, $game->location_id))
                    ->onQueue('bigpack');
                $this->dispatch($job);

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
        //Log::info('end:'. $gameboard->endgame==0);

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
        $gameboard = Gameboard::findOrFail($id);
        $gameboard->fill($request->all());

        // Transformation as we always save UTC in BBDD
        $gameboard->startgame = $gameboard->getUTCStartgame();
        $gameboard->endgame = $gameboard->getUTCEndgame();
        $gameboard->deadline = $gameboard->getUTCDeadline();

        $filename = $request->saveFile('image',$gameboard->path);
        if(isset($filename))
            $gameboard->image = $filename;

        $filename2 = $request->saveFile('imagebig',$gameboard->path);
        if(isset($filename2))
            $gameboard->imagebig = $filename2;

        $gameboard->save();

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

        Storage::disk('s3')->deleteDirectory($gameboard->path);

        $gameboard->delete();
        $message = $gameboard->name. ' borrado';
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
        //Log::info('col:'.$column_name.' , val:'.$column_value);

        if( Input::has('name') && Input::has('value')) {
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

            // Cambio manual de status
            if ($column_name == 'status')
                $gameboard->updateGameView();
        }
    }
}

