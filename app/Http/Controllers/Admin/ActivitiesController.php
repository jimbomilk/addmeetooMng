<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\ActivityRequest;
use App\Http\Controllers\Controller;
use App\Activity;
use App\Category;
use App\Location;
use App\LocationPosition;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;

class ActivitiesController extends Controller {


    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth');
        //$this->beforeFilter('@init',['only'=>['show','edit','create','destroy']]);
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $categories = $this->categories;
        $locations = $this->locations;
        $positions = $this->positions;

        return view('admin.common.create',['name'=>'activities','categories' => $categories, 'locations' => $locations,'positions' => $positions ]);
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

        return redirect()->route('admin.activities.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
            $categories = Category::lists('code','id')->all();
            $locations = Location::lists('name','id')->all();
            $positions = LocationPosition::lists('description','id')->all();


            return view('admin.common.edit',['name'=>'activities','element' => $activity, 'categories' => $categories, 'locations' => $locations,'positions' => $positions ]);
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

        return redirect()->route('admin.activities.index');
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
        return redirect()->route('admin.activities.index');
	}

}
