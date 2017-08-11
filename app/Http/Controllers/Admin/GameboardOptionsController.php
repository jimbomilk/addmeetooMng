<?php namespace App\Http\Controllers\Admin;

use App\Gameboard;
use App\Http\Requests\GameboardOptionsRequest;
use App\Http\Controllers\Controller;
use App\GameboardOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GameboardOptionsController extends Controller {


    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth');
    }

    

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $id = $request->session()->get('gameboard_id');

        $gameboard = Gameboard::findOrFail($id);

        if (isset($gameboard)) {
            $gameboard_options = GameboardOption::where('gameboard_id', '=', $id)->orderBy('order')->paginate();
            $hide_new = $gameboard->auto || $gameboard_options->count()<8;
            return view('admin.common.index', ['name' => 'gameboard_options','game' => $gameboard, 'set' => $gameboard_options, 'hide_new' => $hide_new]);
        }
	}


    public function sendView($element=null)
    {
        if (isset($element))
            return view('admin.common.edit',['name'=>'gameboard_options','element' => $element]);
        else
            return view('admin.common.create',['name'=>'gameboard_options','creation'=>1]);
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(GameboardOptionsRequest $request)
	{
        $gameboardOption = new GameboardOption($request->all());
        $id = $request->session()->get('gameboard_id');
        $gameboardOption->gameboard_id = $id;
        $gameboardOption->save();

        $filename = $request->saveFile('image',$gameboardOption->path);
        if ($filename != $gameboardOption->image) {
            $gameboardOption->image = $filename;
            $gameboardOption->save();
        }

        return redirect()->route($this->indexPage("gameboard_options"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $gameboardOption = GameboardOption::findOrFail($id);
          
        if (isset ($gameboardOption))
        {
            return $this->sendView($gameboardOption);
        }
	}


    public function fastUpdate(Request $request, $id)
    {
        //$option = GameboardOption::find($id);
        $column_name = Input::get('name');
        $column_value = Input::get('value');

        if( Input::has('name') && Input::has('value')) {
            $option = GameboardOption::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }
        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(GameboardOptionsRequest $request, $id)
	{
        $gameboardoption = GameboardOption::findOrFail($id);
        $gameboardoption->fill($request->all());

        $filename = $request->saveFile('image',$gameboardoption->path);
        if(isset($filename))
            $gameboardoption->image = $filename;

        $gameboardoption->save();

        return redirect()->route($this->indexPage("gameboard_options"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $gameboardOption = GameboardOption::findOrFail($id);

        Storage::disk('s3')->delete($gameboardOption->path);
        $gameboardOption->delete();
        $message = $gameboardOption->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => GameboardOption::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("gameboard_options"));
	}
}
