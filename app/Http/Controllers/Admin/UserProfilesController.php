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


class UserProfilesController extends Controller {

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










	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $userprofile = UserGameboard::findOrFail($id);
        if (isset($userprofile))
        {
            return view('admin.common.edit',['name'=>'userprofiles','element' => $userprofile]);
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

        $userprofile = UserProfile::findOrFail($id);
        $userprofile->fill($request->all());
        $userprofile->save();

        return redirect()->route($this->indexPage("users"));
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
