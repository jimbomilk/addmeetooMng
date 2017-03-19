<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\ActivityOptionsRequest;
use App\Http\Controllers\Controller;
use App\ActivityOption;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class ActivityOptionsController extends Controller {


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
        $activity_options = ActivityOption::paginate();
        return view ('admin.common.index',['name'=>'activities','set'=>$activity_options]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'activity_options']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ActivityOptionsRequest $request)
	{
        $activityOptions = new ActivityOption($request->all());
        $activityOptions->save();

        return redirect()->route('admin.activity_options.index');
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
        $activityOption = ActivityOption::findOrFail($id);
          
        if (isset ($activityOption))
        {
            return view('admin.common.edit',['name'=>'activity_options','element' => $activityOption]);
        }

	}


    public function fastUpdate(Request $request, $id)
    {

        $column_name = Input::get('name');
        $column_value = Input::get('value');

        if( Input::has('name') && Input::has('value')) {
            $option = ActivityOption::select()
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
	public function update(ActivityOptionsRequest $request, $id)
	{
        $activityoption = ActivityOption::findOrFail($id);
        $activityoption->fill($request->all());
        $activityoption->save();

        return redirect()->route('admin.activity_options.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $activityOption = ActivityOption::findOrFail($id);
        $activityOption->delete();
        $message = $activityOption->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => ActivityOption::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route('admin.activity_options.index');
	}

}
