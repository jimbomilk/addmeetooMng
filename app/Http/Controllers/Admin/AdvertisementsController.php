<?php namespace App\Http\Controllers\Admin;


use App\Advertisement;
use App\Adscategory;
use App\General;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class AdvertisementsController extends Controller {


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
        if (Auth::user()->is('admin'))
            $advertisements = Advertisement::paginate();
        else
            $advertisements = Auth::user()->advertisements()->paginate();
        return view ('admin.common.index',['name'=>'advertisements','set'=>$advertisements]);
	}

    public function sendView ($element=null)
    {
        $locations = Auth::user()->locations()->lists('name','id');
        $adscategories = Adscategory::all()->pluck('description','id');

        if (isset($element))
            return view('admin.common.edit',['name'=>'advertisements','element' => $element,'adscategories'=>$adscategories,'locations'=>$locations]);
        else
            return view('admin.common.create',['name'=>'advertisements','adscategories'=>$adscategories,'locations'=>$locations]);

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
	public function store(AdvertisementRequest $request)
	{
        $ads = new Advertisement($request->all());
        $ads->user_id = Auth::user()->id;
        $ads->save();

        $file1 = $request->saveFile('imagebig',$ads->path);
        $file2 = $request->saveFile('imagesmall',$ads->path);
        if (isset($file1) && $ads->imagebig != $file1)
            $ads->imagebig = $file1;
        if (isset($file2) && $ads->imagesmall != $file1 )
            $ads->imagesmall = $file2;
        $ads->save();

        return redirect()->route($this->indexPage("advertisements"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request,$id)
	{
        $ads = Advertisement::findOrFail($id);

        if (isset ($ads))
        {
            //$packs = $ads->adspacks()->paginate();
            $request->session()->put('advertisement_id',$id);

            return redirect()->route($this->indexPage("adspacks"));
            //return view('admin.common.index',['name'=>'adspacks','set' => $packs]);
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
        $ads = Advertisement::findOrFail($id);
        if (isset ($ads))
        {
            return $this->sendView($ads);
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AdvertisementRequest $request, $id)
	{
        $ads = Advertisement::findOrFail($id);
        $ads->fill($request->all());

        $file1 = $request->saveFile('imagebig',$ads->path);
        $file2 = $request->saveFile('imagesmall',$ads->path);
        if(isset($file1))
            $ads->imagebig = $file1;
        if(isset($file2))
            $ads->imagesmall = $file2;

        $ads->save();

        return redirect()->route($this->indexPage("advertisements"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $ads = Advertisement::find($id);

        if(isset($ads)) {
            Storage::disk('s3')->delete($ads->path);
            //Log::info('path:' . $ads->path);

            $ads->delete();


            $message = $ads->name . ' deleted';
            if ($request->ajax()) {
                return response()->json([
                    'id' => $id,
                    'message' => $message,
                    'total' => Advertisement::All()->count()
                ]);
            }

            Session::flash('message', $message);
        }else
        {
            $message = $ads->name . ' no se pudo borrar';
            if ($request->ajax()) {
                return response()->json([
                    'id' => $id,
                    'message' => $message,
                    'total' => Advertisement::All()->count()
                ]);
            }

            Session::flash('message', $message);
        }
        return redirect()->route($this->indexPage("advertisements"));
	}



}
