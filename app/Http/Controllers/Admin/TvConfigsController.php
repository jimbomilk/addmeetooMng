<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TvConfigRequest;
use App\TvConfig;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;

class TvConfigsController extends Controller {


    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth');
        //$this->beforeFilter('@init',['only'=>['show','edit','create','destroy']]);
        
    }

    public function init(Route $route)
    {

        
        $parameter = $route->getParameter('tvconfigs');
        if (isset ($parameter))
        {
            $this->tvconfig = TvConfig::findOrFail($parameter);
        }
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $tvconfigs = TvConfig::paginate();

        return view ('admin.common.index',['name'=>'tvconfigs','set'=>$tvconfigs]);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'tvconfigs']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TvConfigRequest $request)
	{
        $tvconfig = new TvConfig($request->all());
        $tvconfig->save();

        return redirect()->route('admin.tvconfigs.index');
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
        $locations = Location::lists('name','id')->all();
        $tvconfig = TvConfig::findOrFail($id);
        
        if (isset ($tvconfig) && isset($locations))
        {
            
            return view('admin.common.edit',['name'=>'tvconfigs','element' => $tvconfig, 'locations' => $locations]);
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(TvConfigRequest $request, $id)
	{
        $this->tvconfig = TvConfig::findOrFail($id);
        $this->tvconfig->fill($request->all());
        $this->tvconfig->save();

        return redirect()->route('admin.tvconfigs.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $this->tvconfig = TvConfig::findOrFail($id);
        $this->tvconfig->delete();
        $message = $this->tvconfig->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => TvConfig::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route('admin.tvconfigs.index');
	}

}
