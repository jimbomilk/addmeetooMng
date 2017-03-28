<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Log;
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
use App\Events\ScreenEvent;




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

    public function index()
	{
        if (Auth::user()->is('admin'))
            $gameboards = Gameboard::paginate();
        else
            $gameboards = Auth::user()->gameboards()->paginate();

        return view ('admin.common.index',['name'=>'gameboards','set'=>$gameboards]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $locations = Auth::user()->locations()->lists('name','id');
        $activities = Activity::all()->pluck('name','id');
        return view('admin.common.create',['name'=>'gameboards','statuses'=>Status::$values,'locations'=>$locations,'activities'=>$activities]);
	}



    public function store(GameboardRequest $request)
    {
        // Cuando creamos un gameboard, tenemos que crear tb todas sus opciones (copia de la actividad)
        $gameboard = new Gameboard($request->all());

        $gameboard->createGame();

        return redirect()->route(Auth::user()->type.".gameboards.index");
    }

    //
    //







	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $game = Gameboard::findOrFail($id);

        if (isset ($game))
        {
            $options = $game->gameboardOptions()->paginate();
            return view('admin.common.index',['name'=>'gameboard_options','set' => $options]);
        }
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

        $locations = Auth::user()->locations()->lists('name','id');
        $activities = Activity::all()->pluck('name','id');

        if (isset($gameboard))
        {
           return view ('admin.common.edit',['name'=>'gameboards','element'=>$gameboard,'statuses'=>Status::$desc,'locations'=>$locations,'activities'=>$activities]);
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

        $prev_status = $this->gameboard->status;

        $this->gameboard->fill($request->all());
        $this->gameboard->save();

        $curr_status = $this->gameboard->status;

        if ($prev_status != $curr_status)
        {
            //Actualizamos la pantalla
            $this->createGameView($this->gameboard);
        }

        return redirect()->route(Auth::user()->type.".gameboards.index");
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
    {
        $this->gameboard = Gameboard::findOrFail($id);
        $this->gameboard->delete();
        $message = $this->gameboard->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Gameboard::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route(Auth::user()->type.".gameboards.index");
    }

}
