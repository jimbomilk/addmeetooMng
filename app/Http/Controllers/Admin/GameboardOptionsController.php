<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\GameboardOptionsRequest;
use App\Http\Controllers\Controller;
use App\GameboardOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

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
	public function index()
	{
        $gameboard_options = GameboardOption::paginate();
        return view ('admin.common.index',['name'=>'gameboard_options','set'=>$gameboard_options]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'gameboard_options']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(GameboardOptionsRequest $request)
	{
        $gameboardOptions = new GameboardOption($request->all());
        $gameboardOptions->save();

        return redirect()->route('admin.gameboard_options.index');
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
            return view('admin.common.edit',['name'=>'gameboard_options','element' => $gameboardOption]);
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
        $gameboardoption->save();

        return redirect()->route('admin.gameboard_options.index');
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
        return redirect()->route('admin.gameboard_options.index');
	}

}
