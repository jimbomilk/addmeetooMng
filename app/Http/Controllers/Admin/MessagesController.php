<?php namespace App\Http\Controllers\Admin;

use App\Console\Commands\SendScreen;
use App\Events\Envelope;
use App\General;
use App\Http\Requests\MessageRequest;
use App\Http\Controllers\Controller;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Events\AdsEvent;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller {
    public $now = null;
    public $search="";

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
        $this->search = $request->get('search');
        $type = $request->get('type');

        $where = General::getRawWhere(Message::$searchable,$this->search);
        if (isset($type) && $type!='')
            $where .= ' and type='.$type;

        $types = General::getEnumValues('messages','type') ;
        //dd($types);


        $messages = Auth::user()->messageswhere($where);


        return view ('admin.common.index',['searchable'=>'1','name'=>'messages','set'=>$messages,'types'=>$types]);
	}


    public function sendView($element=null)
    {
        $types = General::getEnumValues('messages','type') ;
        $locations = Auth::user()->locations()->pluck('name','id');
        if (isset($element)) {

            $element->start = $element->localStart;
            $element->end = $element->localEnd;
            return view('admin.common.edit', ['name' => 'messages','types'=>$types,'locations'=>$locations, 'element' => $element]);
        }
        else
            return view('admin.common.create',['name'=>'messages','types'=>$types,'now'=>$this->now,'locations'=>$locations]);
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $this->now = Carbon::now(Config::get('app.timezone'))->format('Y-m-d\TH:i');
        return $this->sendView();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(MessageRequest $request)
	{
        $message = new Message($request->all());
        $message->start = $message->getUTCStart();
        $message->end = $message->getUTCEnd();
        $message->save();

        $filename = $request->saveFile('image',$message->path);
        if (isset($filename) && $filename != $message->image) {
            $message->image = $filename;
            $message->save();
        }

        $filename2 = $request->saveFile('imagebig',$message->path);
        if (isset($filename2) && $filename2 != $message->imagebig) {
            $message->imagebig = $filename2;
            $message->save();
        }

        return redirect()->route($this->indexPage("messages"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

        $message = Message::find($id);

        if (isset($message)) {
            $env = new Envelope();
            $env->stext = $message->stext;
            $env->ltext = $message->ltext;
            $env->image = $message->image;
            $env->type = 'info';
            $env->location_img = $message->logo;
            $env->background = $message->imagebig;


            //SendScreen ss = new SendScreen();

            //Publicamos
            event(new AdsEvent($env, 'location'.$message->location_id));

            Session::flash('message', 'Mensaje enviado:' . $message->stext);
        }
        else{
            Session::flash('message', 'Error envio');
        }
        return redirect()->route($this->indexPage("messages"));
        return view ('admin.common.index',['name'=>'messages','set'=>$advertisements]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $message = Message::findOrFail($id);
          
        if (isset ($message))
        {
            return $this->sendView($message);
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
        $message = Message::findOrFail($id);
        //dd($message);
        $message->fill($request->all());
        $message->start = $message->getUTCStart();
        $message->end = $message->getUTCEnd();
        $message->save();// no está duplicado es que necesitamos ponerle la hora para que el fichero se guarde con la hora correcta

        $filename = $request->saveFile('image', $message->path);
        if (isset($filename))
            $message->image = $filename;


        $filename2 = $request->saveFile('imagebig',$message->path);
        if(isset($filename2))
            $message->imagebig = $filename2;

        $message->save();

        return redirect()->route($this->indexPage("messages"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $message = Message::findOrFail($id);
        Storage::disk('s3')->deleteDirectory($message->path);

        $message->delete();
        $message = $message->id. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Message::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("messages"));
	}

}
