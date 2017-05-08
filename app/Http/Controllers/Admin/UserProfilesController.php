<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserGameboardRequest;
use App\location;
use App\UserGameboard;
use App\UserProfile;
use Illuminate\Http\Request;
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


        $file1 = $request->saveFile('avatar',$userprofile->user->path);
        if(isset($file1))
            $userprofile->avatar = $file1;
        $userprofile->save();

        return redirect()->route($this->indexPage("users"));
    }


}
