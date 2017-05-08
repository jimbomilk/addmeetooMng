<?php namespace App\Http\Controllers\Admin;

use App\Country;
use App\General;
use App\Http\Controllers\Controller;

use App\Http\Requests\LocationUpdateRequest;
use App\Location;
use App\Http\Requests\LocationRequest;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;




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


    public function sendView ($element=null)
    {
        $owners = User::where('type','=','owner')->lists('name','id');
        $categories = General::getEnumValues('locations','category');
        $countries = Country::all()->pluck('name','id');

        $map = General::createMap($element);

        if (isset($element))
            return view('admin.common.edit',['name'=>'locations','element' => $element,'owners' =>$owners,'categories'=>$categories,'countries'=>$countries,'map'=>$map]);
        else
            return view('admin.common.create',['name'=>'locations','owners' =>$owners,'categories'=>$categories,'countries'=>$countries,'map'=>$map]);
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



    public function store(LocationRequest $request)
    {
        $location = new Location($request->all());
        $location->owner_id = Auth::user()->id;
        $location->save();

        $filename = $request->saveFile('logo',$location->path);
        if ($filename != $location->logo) {
            $location->logo = $filename;
            $location->save();
        }
        return redirect()->route($this->indexPage("locations"));
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
            return $this->sendView($location);
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update(LocationUpdateRequest $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->fill($request->all());

        $filename = $request->saveFile('logo',$location->path);
        if(isset($filename))
            $location->logo = $filename;

        $location->save();

        return redirect()->route($this->indexPage("locations"));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
    {
        $location = Location::findOrFail($id);

        Storage::disk('s3')->deleteDirectory($location->path);

        $location->delete();
        $message = $location->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Location::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("locations"));
    }


    /*
     * Game restarting : all
     */
    public function restart($location)
    {
        $location = Location::findOrFail($location);
        if (isset($location)) {
            foreach ($location->gameboards as $gameboard) {
                if ($gameboard->destroyGame())
                    $gameboard->createGame();
            }
        }

        Session::flash('message','Location restarted');
        return redirect()->route($this->indexPage("locations"));
    }

    public function updateCoords(LocationRequest $request)
    {

    }


}
