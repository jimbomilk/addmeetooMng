<?php namespace App\Http\Controllers\Admin;

use App\Events\Envelope;
use App\General;
use App\Http\Requests\MessageRequest;
use App\Http\Controllers\Controller;
use App\Incidence;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Events\MessageEvent;
use Illuminate\Support\Facades\Storage;

class IncidencesController extends Controller {


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
	public function index(Request $request)
	{
        $search = $request->get('search');
        $where = General::getRawWhere(Incidence::$searchable,$search);
        if(!Auth::user()->is('admin') ) {
            $where .= ' and location_id in ( -1';
            if(Auth::user()->locations()->count()>0)
                $where .= ',';
            $where .= Auth::user()->locations()->pluck('id')->implode(',');
            $where .= ')';
        }

        //Log::info('Msg where:' . $where);

        $incidences = Incidence::whereRaw($where)
                ->paginate();


        return view ('admin.common.index',['searchable'=>'1','name'=>'incidences','set'=>$incidences]);
	}


    public function sendView($element=null)
    {
        $locations = Auth::user()->locations()->pluck('name','id');
        if (isset($element)) {
            return view('admin.common.edit', ['name' => 'incidences','locations'=>$locations, 'element' => $element]);
        }
        else
            return view('admin.common.create',['name'=>'incidences','locations'=>$locations]);
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
	public function store(MessageRequest $request)
	{
        $incidence = new Incidence($request->all());
        $incidence->save();

        $filename = $request->saveFile('attachnent',$incidence->path);
        if (isset($filename) && $filename != $incidence->attachment) {
            $incidence->image = $filename;
            $incidence->save();
        }

        return redirect()->route($this->indexPage("incidences"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

        return redirect()->route($this->indexPage("incidences"));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $incidence = Incidence::findOrFail($id);
          
        if (isset ($incidence))
        {
            return $this->sendView($incidence);
        }

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(MessageRequest $request, $id)
	{
        $incidence = Incidence::findOrFail($id);
        $incidence->fill($request->all());
        $incidence->save();


        $filename = $request->saveFile('attachment','message'.$incidence->id);
        if(isset($filename))
            $incidence->image = $filename;

        $incidence->save();

        return redirect()->route($this->indexPage("incidences"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $incidence = Incidence::findOrFail($id);
        Storage::disk('s3')->deleteDirectory($incidence->path);

        $incidence->delete();
        $incidence = $incidence->id. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$incidence,
                'total' => Message::All()->count()
            ]);
        }

        Session::flash('message',$incidence);
        return redirect()->route($this->indexPage("incidences"));
	}

    public function fastUpdate($id)
    {
        $column_name = Input::get('name');
        $column_value = Input::get('value');
        //Log::info('col:'.$column_name.' , val:'.$column_value);

        if( Input::has('name') && Input::has('value')) {
            $this->updateGame($id,$column_name,$column_value);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function updateIncidence($id,$column_name,$column_value)
    {
        $in = Incidence::findOrFail($id);
        if (isset($in))
        {
            $in->$column_name = $column_value;
            $in->save();

        }
    }

}
