<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\ActivityRequest;
use App\Http\Controllers\Controller;
use App\Activity;
use App\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActivitiesController extends Controller {


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
        $activities = Activity::paginate();
        return view ('admin.common.index',['name'=>'activities','set'=>$activities]);
	}

    public function sendView ($element=null)
    {
        $types = General::getEnumValues('activities','type') ;
        $categories = General::getEnumValues('activities','category') ;
        if (isset($element))
            return view('admin.common.edit',['name'=>'activities','element' => $element,'types'=>$types,'categories'=>$categories]);
        else
            return view('admin.common.create',['name'=>'activities','types'=>$types,'categories'=>$categories]);

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
	public function store(ActivityRequest $request)
	{
        $activity = new Activity($request->all());
        $activity->save();

        return redirect()->route($this->indexPage("activities"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request,$id)
	{
        $activity = Activity::findOrFail($id);

        if (isset ($activity))
        {
            //$options = $activity->activityOptions()->paginate();
            $request->session()->put('activity_id',$id);
            return redirect()->route($this->indexPage("activity_options"));
            //return view('admin.common.index',['name'=>'activity_options','set' => $options]);
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
        $activity = Activity::findOrFail($id);
          
        if (isset ($activity))
        {
            return $this->sendView($activity);
        }

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ActivityRequest $request, $id)
	{
        $this->activity = Activity::findOrFail($id);
        $this->activity->fill($request->all());
        $this->activity->save();

        return redirect()->route($this->indexPage("activities"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $this->activity = Activity::findOrFail($id);
        $this->activity->delete();
        $message = $this->activity->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Activity::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("activities"));
	}

}
