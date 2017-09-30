<?php namespace App\Http\Controllers\Admin;

use App\Gameboard;
use App\Http\Controllers\Controller;

use App\Location;
use App\Http\Requests\UserGameboardRequest;
use App\UserGameboard;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;



class UserGameBoardsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public $sel_location=null;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
	{

        $locations = Auth::user()->locations()->lists('name','id');

        $this->sel_location = $request->get('location_id');
        if (!isset($this->sel_location) && count($locations)>0)
            $this->sel_location = $locations->keys()->first();


        $usergameboards = UserProfile::globalRanking($this->sel_location,true);
/*
        if (Auth::user()->is('admin'))
            $usergameboards = UserGameboard::where('users.type','=','user')
                ->join('users', 'user_gameboards.user_id', '=' , 'users.id')
                ->orderby('points','desc')->paginate();
        else
            $usergameboards = UserGameboard::where('locations.owner_id','=',Auth::user()->id)
                ->where('users.type','=','user')
                ->join ('user_profiles','user_gameboards.user_id','=','user_profiles.user_id')
                ->join ('locations', 'user_profiles.location_id', '=' , 'locations.id')
                ->join ('users', 'user_gameboards.user_id', '=' , 'users.id')

                ->orderby('points','desc')
                ->paginate();
*/


        return view('admin.common.index',['locations'=>$locations,'withlocations'=>1,'name'=>'usergameboards','set'=>$usergameboards,'hide_new'=>1,'hide_delete'=>1]);
	}


    public function sendView ($element=null)
    {
        if (isset($element))
            return view('admin.common.edit',['name'=>'usergameboards','element' => $element]);
        else
            return view('admin.common.create',['name'=>'usergameboards']);
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


    public function store(UserGameboardRequest $request)
    {

        $usergameboard = new UserGameboard($request->all());
        $usergameboard->save();

        //$result = $request->file('logo')->move(base_path() . '/public/images/location'.$location->id, $location->logo);

        return redirect()->route($this->indexPage("usergameboards"));
    }



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        //Log::info('entrando '.$id);
        $usergameboard = UserGameboard::findOrFail($id);
        //Log::info('user: '.$usergameboard);
        if (isset($usergameboard))
        {
            return $this->sendView($usergameboard);
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update(UserGameboardRequest $request, $id)
    {

        $usergameboard = UserGameboard::findOrFail($id);
        $usergameboard->fill($request->all());
        $usergameboard->save();

        return redirect()->route($this->indexPage("usergameboards"));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
    {
        $usergameboard = UserGameboard::findOrFail($id);
        $usergameboard->delete();
        $message = $usergameboard->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Location::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("usergameboards"));
    }





}
