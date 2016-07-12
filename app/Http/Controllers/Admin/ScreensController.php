<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScreenRequest;
use App\Screen;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;

class ScreensController extends Controller {


    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth');
        //$this->beforeFilter('@init',['only'=>['show','edit','create','destroy']]);
    }

    public function init(Route $route)
    {
        $parameter = $route->getParameter('screens');
        if (isset ($parameter))
        {
            $this->screen = Screen::findOrFail($parameter);
        }
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $screens = Screen::paginate();

        return view ('admin.common.index',['name'=>'screens','set'=>$screens]);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'screens']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ScreenRequest $request)
	{
        $screen = new Screen($request->all());
        $screen->save();

        return redirect()->route('admin.screens.index');
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
        $screen = Screen::findOrFail($id);
        if (isset($screen))
            return view('admin.common.edit',['name'=>'screens','element' => $screen]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ScreenRequest $request, $id)
	{
        $this->screen = Screen::findOrFail($id);
        $this->screen->fill($request->all());
        $this->screen->save();

        return redirect()->route('admin.screens.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $this->screen = Screen::findOrFail($id);
        $this->screen->delete();
        $message = $this->screen->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Screen::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route('admin.screens.index');
	}

}
