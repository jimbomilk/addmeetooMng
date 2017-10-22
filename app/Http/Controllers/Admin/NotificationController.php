<?php

namespace App\Http\Controllers\Admin;

use App\Gameboard;
use App\General;
use App\Http\Controllers\Controller;
use App\location;
use App\Notification;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Moathdev\OneSignal\Exceptions\FailedToSendNotificationException;
use Moathdev\OneSignal\Facade\OneSignal;

class NotificationController extends Controller
{
    public $search="";

    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->search = $request->get('search');
        $where = General::getRawWhere(Notification::$searchable,$this->search);
        $notifications = Auth::user()->notifications($where);

        $games = Auth::user()->liveGameboards();

        return view ('admin.common.index',['searchable'=>'1','name'=>'notifications','set'=>$notifications,'games'=>$games]);
    }

    public function sendView($element=null)
    {
        $locations = Auth::user()->locations()->pluck('name','id');
        $games = Auth::user()->liveGameboards()->pluck('name','id');
        $games->prepend('A todos los usuarios');
        if (isset($element)) {

            return view('admin.common.edit', ['name' => 'notifications','locations'=>$locations, 'element' => $element, 'games' => $games]);
        }
        else
            return view('admin.common.create',['name'=>'notifications','locations'=>$locations, 'games' => $games]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->sendView();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notification = new Notification($request->all());
        $notification->save();

        return redirect()->route($this->indexPage("notifications"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $notification = Notification::find($id);
        if( isset($notification)){
            // Vamos a enviar a todos los destinatarios...
            $OneSignalIds =[];
            if ($notification->who == 0)
            {
               $location = Location::find($notification->location_id);

               if (isset($location))
               {
                   $users = $location->pushUsers()->get();

                   foreach($users as $push_user){
                       //Log::info('User push:'.$push_user->id);
                       if ($push_user->id!='0')
                           array_push($OneSignalIds,$push_user->id);
                   }
               }

            }
            else{
                $game = Gameboard::find($notification->who);
                //Log::info('Game:'.$game->id);
                if (isset($game)){
                    $users = $game->gameboardUsers()->get();
                    foreach($users as $puser){
                        //Log::info('pushid:'.$puser->pushId);
                        if ($puser->pushId!='0' && $puser->pushId!='' )
                            array_push($OneSignalIds,$puser->pushId);
                    }
                }
            }


            try {
                //Log::info('One:'.implode($OneSignalIds));
                if (count($OneSignalIds)>0) {
                    $res = OneSignal::SendNotificationToSpecificUsers(
                        $notification->title,
                        $notification->text,
                        $OneSignalIds);
                    $msg = '. Notificación enviada a ' . count($OneSignalIds) . ' usuarios de ' . $users->count();
                }
                else
                    $msg = 'No hay usuarios a los que enviar la notificación';
            } catch (FailedToSendNotificationException $e) {

                $msg = 'Error: '.$e->getMessage();
            }

            if ($request->ajax() && isset($msg))
            {
                return response()->json([
                    'id' => $id,
                    'message' =>$msg,
                    'total' => Notification::All()->count()
                ]);

            }

            Session::flash('message',$msg);
            return redirect()->route($this->indexPage("notifications"));



        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = Notification::findOrFail($id);

        if (isset ($notification))
        {
            return $this->sendView($notification);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->fill($request->all());
        $notification->save();
        return redirect()->route($this->indexPage("notifications"));
    }

    public function fastUpdate($id)
    {
        $column_name = Input::get('name');
        $column_value = Input::get('value');
        //Log::info('col:'.$column_name.' , val:'.$column_value);

        if( Input::has('name') && Input::has('value')) {
            $this->updateNotification($id,$column_name,$column_value);
            return response()->json([ 'code'=>200], 200);
        }

        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }

    public function updateNotification($id,$column_name,$column_value)
    {
        $notification = Notification::findOrFail($id);
        if (isset($notification))
        {
            $notification->$column_name = $column_value;
            $notification->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        $msg = $notification->id. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$msg,
                'total' => Notification::All()->count()
            ]);
        }

        Session::flash('message',$msg);
        return redirect()->route($this->indexPage("notifications"));
    }
}
