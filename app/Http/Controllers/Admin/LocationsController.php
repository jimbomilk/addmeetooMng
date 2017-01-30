<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Location;
use App\Http\Requests\LocationRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use GeneaLabs\Phpgmaps\Facades\Phpgmaps;
use Illuminate\Support\Facades\Auth;




class LocationsController extends Controller {

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
            $locations = Location::paginate();
        else
            $locations = Location::where('owner_id','=',Auth::user()->id) ->paginate();

        return view ('admin.common.index',['name'=>'locations','set'=>$locations]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'locations']);
	}


    public function store(LocationRequest $request)
    {

        $location = new Location($request->all());

        $location->owner_id = Auth::user()->id;

        $location->save();

        return redirect()->route(Auth::user()->type.".locations.index");
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
        $location = Location::findOrFail($id);
        if (isset($location))
        {
            $marker = $this->maps($location);
            return view ('admin.common.edit',['name'=>'locations','element'=>$location,'marker'=>$marker]);
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update(LocationRequest $request, $id)
    {

        $this->location = Location::findOrFail($id);
        $this->location->fill($request->all());
        $this->location->save();

        return redirect()->route('admin.locations.index');
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
    {
        $this->location = Location::findOrFail($id);
        $this->location->delete();
        $message = $this->location->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Location::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route('admin.locations.index');
    }

    public function maps(Location $location)
    {
        $marker = array();
        $config = array();
        $config['center'] = $location->geolocation;
        if ($location->geolocation == null )
        {
            return;
        }
        $config['onboundschanged'] = 'if (!centreGot) {
                    marker_0.setOptions({
                        position: new google.maps.LatLng('.$location->geolocation.')
                    });
                }
                centreGot = true;';


        $circle = array();
        $circle['center'] = $location->geolocation;
        $circle['radius'] = '5000';
        \Gmaps::add_circle($circle);

        \Gmaps::initialize($config);
        \Gmaps::add_marker($marker);
        $map = \Gmaps::create_map();
        $marker=  array('map_js' => $map['js'], 'map_html' => $map['html']);
        return $marker;

    }

}
