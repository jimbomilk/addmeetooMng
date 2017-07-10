<?php namespace App\Http\Controllers\Admin;

use App\Events\Envelope;
use App\General;
use App\Http\Requests\MessageRequest;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Events\MessageEvent;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller {


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
        $where = General::getRawWhere(Message::$searchable,$search);
        if(!Auth::user()->is('admin') ) {
            $where .= ' and location_id in ( -1';
            if(Auth::user()->locations()->count()>0)
                $where .= ',';
            $where .= Auth::user()->locations()->pluck('id')->implode(',');
            $where .= ')';
        }

        Log::info('Msg where:' . $where);

        $messages = Message::whereRaw($where)
                ->paginate();


        return view ('admin.common.index',['searchable'=>'1','name'=>'messages','set'=>$messages]);
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
            return view('admin.common.create',['name'=>'messages','types'=>$types,'locations'=>$locations]);
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
        $message = new Message($request->all());
        $message->start = $message->getUTCStart();
        $message->end = $message->getUTCEnd();
        $message->save();

        $filename = $request->saveFile('image',$message->path);
        if (isset($filename) && $filename != $message->image) {
            $message->image = $filename;
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
        $message = Message::findOrFail($id);

        $env = new Envelope();
        $env->stext = $message->stext;
        $env->ltext = $message->ltext;
        $env->image = $message->image;


        //Publicamos
        event(new MessageEvent($env, 'location1'));

        Session::flash('message','Mensaje enviado:'.$message);
        return redirect()->route($this->indexPage("messages"));
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
        $message->fill($request->all());
        $message->start = $message->getUTCStart();
        $message->end = $message->getUTCEnd();
        $message->save();


        $filename = $request->saveFile('image','message'.$message->id);
        if(isset($filename))
            $message->image = $filename;

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
