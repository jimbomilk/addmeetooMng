<?php namespace App\Http\Controllers\Admin;

use App\General;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Controllers\Controller;

use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller {


    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        //$this->beforeFilter('@init',['only'=>['show','edit','destroy']]);
    }

    public function init(Route $route)
    {
        $this->user = User::findOrFail($route->getParameter('users'));
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
    {
        $search = $request->get('search');

        if (isset($search) and $search != ""){
            $where = General::getRawWhere(User::$searchable,$search);
            $users = User::whereRaw($where)
                ->paginate();
        }
		else
            $users = User::paginate();
        return view ('admin.common.index',['searchable'=>'1','name'=>'users','set'=>$users]);
	}


    public function sendView($element=null)
    {
        $types = General::getEnumValues('users','type') ;
        if (isset($element))
            return view('admin.common.edit',['name'=>'users','element' => $element,'types'=>$types]);
        else
            return view('admin.common.create',['name'=>'users','types'=>$types]);
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
	public function store(CreateUserRequest $request)
	{
		$user = new User($request->all());
        $user->save();

        // Además del usuario hay que crear su profile
        $profile = new UserProfile();
        $profile->user_id = $user->id;
        $profile->save();

        return redirect()->route('admin.users.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $profile = UserProfile::findOrFail($id);
        $genders = General::getEnumValues('user_profiles','gender');
        return view('admin.common.edit',['name'=>'userprofiles','element'=>$profile,'genders'=>$genders]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = User::findOrFail($id);
        if (isset ($user)) {
            return $this->sendView($user);
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditUserRequest $request, $id)
	{
        $this->user = User::findOrFail($id);
        $this->user->fill($request->all());
        $this->user->save();

        return redirect()->route('admin.users.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,Request $request)
	{
        $user = User::findOrFail($id);


        Storage::disk('s3')->delete($user->path);

        $user->delete();
        $message = $user->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => User::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route('admin.users.index');
	}

}
