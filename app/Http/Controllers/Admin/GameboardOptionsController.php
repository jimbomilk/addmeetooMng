<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\GameboardOptionsRequest;
use App\Http\Controllers\Controller;
use App\GameboardOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

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
        $gameboard_options = GameboardOption::where('gameboard_id','=',$id)->paginate();

        return view ('admin.common.index',['name'=>'gameboard_options','set'=>$gameboard_options]);
	}


    public function sendView ($element=null)
    {
        if (isset($element))
            return view('admin.common.edit',['name'=>'gameboard_options','element' => $element]);
        else
            return view('admin.common.create',['name'=>'gameboard_options']);
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return sendView();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(GameboardOptionsRequest $request)
	{
        $gameboardOptions = new GameboardOption($request->all());
        $id = $request->session()->get('gameboard_id');
        $gameboardOptions->gameboard_id = $id;
        $gameboardOptions->save();

        $filename = $request->saveFile('image','gameboard'.$gameboardOptions->id);
        if ($filename != $gameboardOptions->image) {
            $gameboardOptions->image = $filename;
            $gameboardOptions->save();
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
            return sendView($gameboardOption);

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


        $filename = $request->saveFile('image','gameboard'.$gameboardoption->id);
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

        File::deleteDirectory(storage_path().'/app/public/gameboard'.$gameboardOption->id);

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
