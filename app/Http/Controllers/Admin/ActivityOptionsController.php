<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\ActivityOptionsRequest;
use App\Http\Controllers\Controller;
use App\ActivityOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

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
	public function index(Request $request)
	{
        //$activity_options = ActivityOption::paginate();

        $id = $request->session()->get('activity_id');
        $activity_options = ActivityOption::where('activity_id','=',$id)->paginate();

        return view ('admin.common.index',['name'=>'activity_options','set'=>$activity_options]);
	}

    public function sendView ($element=null)
    {
        if (isset($element))
            return view('admin.common.edit',['name'=>'activity_options','element' => $element]);
        else
            return view('admin.common.create',['name'=>'activity_options']);

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
	public function store(ActivityOptionsRequest $request)
	{
        $activityOption = new ActivityOption($request->all());
        $id = $request->session()->get('activity_id');
        $activityOption->activity_id = $id;
        $activityOption->save();


        $filename = $request->saveFile('image',$activityOption->path);
        if ($filename != $activityOption->image) {
            $activityOption->image = $filename;
            $activityOption->save();
        }

        return redirect()->route($this->indexPage("activity_options"));
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
            return $this->sendView($activityOption);

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

        $filename = $request->saveFile('image',$activityoption->path);
        if(isset($filename))
            $activityoption->image = $filename;

        $activityoption->save();

        return redirect()->route($this->indexPage("activity_options"));
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

        Storage::disk('s3')->delete($activityOption->path);
        //Log::info('path:'.$activityOption->path);
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
        return redirect()->route($this->indexPage("activity_options"));
	}

}
