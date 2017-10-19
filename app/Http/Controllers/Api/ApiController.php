<?php

namespace App\Http\Controllers\Api;

use App\Adspack;
use App\Events\Envelope;
use App\Events\MessageEvent;
use App\Gameboard;
use App\Incidence;
use App\location;
use App\Status;
use App\User;
use App\UserGameboard;
use App\UserProfile;
use App\UserPush;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use NZTim\Mailchimp\MailchimpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use NZTim\Mailchimp\MailchimpFacade;


class ApiController extends Controller
{
    public function gameinfo($gameboard_id)
    {
        //Log::info('ENTRANDO gameinfo');
        try {
            $gameboard = Gameboard::findOrFail($gameboard_id);
            if (!isset($gameboard))
                return response()->json(['error' => "SORRY, ACTIVITY CLOSED"], HttpResponse::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json(['error' => "ACTIVITY NOT FOUND"], HttpResponse::HTTP_NOT_FOUND);
        }



        // Ademas del game queremos enviar las opciones

        $options = $gameboard->gameboardOptions()->get();
        $activity = $gameboard->activity()->get();
        $data = array();
        $data['gameboard'] = $gameboard;
        $data['activity'] = $activity;
        $data['options'] = $options;

        return json_encode($data);
    }


    public function gameboard($gameboard_id, Request $request)
    {
        //Log::info('ENTRANDO gameboard');
        $input = $request->all();
        try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $gameboard = Gameboard::findOrFail($gameboard_id);
            if (!isset($gameboard))
                return response()->json(['error' => "SORRY, ACTIVITY CLOSED"], HttpResponse::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json(['error' => "ACTIVITY NOT FOUND"], HttpResponse::HTTP_NOT_FOUND);
        }



        // Ademas del game queremos enviar las opciones

        $options = $gameboard->gameboardOptions()->get();
        $activity = $gameboard->activity()->get();
        $data = array();
        $data['gameboard'] = $gameboard;
        $data['activity'] = $activity;
        $data['options'] = $options;


        return json_encode($data);
    }

    public function useroptions($gameboard_id, Request $request)
    {
        $input = $request->all();
        try {
            $gameboard = Gameboard::findOrFail($gameboard_id);

            if (!isset($gameboard))
                return response()->json(['error' => "JUEGO NO ENCONTRADO"], HttpResponse::HTTP_UNAUTHORIZED);
            if (!$gameboard->participationStatus)
                return response()->json(['error' => "JUEGO CERRADO"], HttpResponse::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json(['error' => "JUEGO NO ENCONTRADO"], HttpResponse::HTTP_NOT_FOUND);
        }

        try {
            $user = JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $values = $input['values'];
        // Guardar las opciones, generar un mensaje para la pantalla y responder OK

        $result = UserGameboard::firstOrNew(['gameboard_id' => $gameboard_id, 'user_id' => $user->id]);
        $second = $result->values != "";

        //Profile
        $profile = $user->locationProfile($gameboard->location_id);
        if (!isset($profile))
            return response()->json(['Error: perfil de usuario no definido'], HttpResponse::HTTP_NOT_FOUND);

        // GUARDAMOS PUNTOS y RECALCULAMOS TOP RANK
        if (!$second) {
            $result->points = $result->points + $gameboard->activity->reward_participation;
            $profile->points = $profile->points + $gameboard->activity->reward_participation;
            $profile->save();

            //$user->profile->recalculateTopRank($gameboard->location_id);
        }

        $result->values = json_encode($values);
        $result->save();

        // A pantalla
        $message = new Envelope();
        $message->stext = strtoupper($user->name);
        $message->ltext = $gameboard->name;
        $message->type = 'message';
        $message->image = $profile->avatar;
        event(new MessageEvent($message, 'location'.$gameboard->location_id));

        // A movil
        $message->ltext = $gameboard->name . ":";
        $message->setText($user->name, $values);
        $message->reward = $second? 0 : $gameboard->activity->reward_participation;


        return json_encode($message);
    }


    // Devuelve todos los gameboards activos para el día de hoy
    public function gameboards(Request $request)
    {
        $location_id = $request->get('location');


        if(isset($location_id)) {
            $gameboards = Gameboard::where('location_id', $location_id)->orderby('deadline')->get();
        }
        else
            $gameboards = Gameboard::all()->orderby('deadline');
        //$now = Carbon::now(Config::get('app.timezone'));
        $gameviews = array();
        foreach($gameboards as $gameboard)
        {
            //$start = Carbon::parse($gameboard->startgame); //en UTC
            //$end = Carbon::parse($gameboard->endgame);

            //Log::info('now1:'.$now.' start:'.$start.' end:'.$end);
            if ($gameboard->status>=Status::RUNNING && $gameboard->status<Status::HIDDEN){

                $gameview = $gameboard->getGameView();
                if (isset($gameview))
                    $gameviews[] = $gameview;
            }
        }
        return json_encode($gameviews);

    }

    public function location(Request $request)
    {
        $location_id = $request->get('location');
        return json_encode(Location::find($location_id));
    }


    public function authenticate(Request $request)
    {
        //Log::info('ENTRANDO authenticate');
        $credentials = $request->only('email', 'password');
        $location = $request->get('location');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['result' => 'wrong email or password.']);
        }
        $user = JWTAuth::toUser($token);

        // Si llega un usuario sin profile , se lo creamos.
        $profile = $user->locationProfile($location);
        if (!isset($profile))
            $profile = $this->createProfile($user,$location);

        return response()->json(['token' => $token, 'user' => $user, 'profile' => $profile]);

    }


    public function registerDevicePush(Request $request)
    {
        //Log::info('ENTRANDO registerDevice');
        $input = $request->all();
        /*Log::info('pushId:'.$input['userId']);
        Log::info('pushToken:'.$input['pushToken']);
        Log::info('gameboardId:'.$input['gameboardId']);
        Log::info('token:'.$input['token']);
        Log::info('location:'.$input['location']);*/

        $push_user = UserPush::firstOrNew(['id' => $input['userId']]);
        if (isset($push_user) )
        {
            $push_user->id = $input['userId'];
            $push_user->token = $input['pushToken'];
            $push_user->location_id = $input['location'];
            // Guardar usuario si viene
            if (isset($input['token'])) {
                $user = JWTAuth::toUser($input['token']);
                if (isset($user)) {
                    $push_user->user_id = $user->id;

                    // Guardar en game_user si viene
                    if (isset($input['gameboardId'])) {
                        $gameUser = UserGameboard::firstOrNew(['gameboard_id' => $input['gameboardId'], 'user_id' => $user->id]);

                        if (isset($gameUser)) {
                            $gameUser->pushId = $input['userId'];
                            $gameUser->pushToken = $input['pushToken'];
                            $gameUser->save();
                        }
                    }
                }
            }
            $push_user->save();
        }

        return response()->json(['result' => 'Device registrado.']);

    }


    public function newAccount(Request $request)
    {
        //Log::info('ENTRANDO newaccount');
        // Recogemos las credenciales
        $credentials = $request->only('email', 'password');
        $locationId = $request->get('location');
        $profile=null;
        $token=null;


        // Vemos si existe en la base de datos. Si existe , damos error
        $user = User::where('email',$credentials['email'])->first();

        if ($user!= null) {

            // Si existe el profile con esa location error, sino la creamos
            if ($user->locationProfile($locationId) != null)
                return response()->json(['result' => 'El usuario ya existe.']);
            else {
                $token = JWTAuth::attempt($credentials);
                $profile = $this->createProfile($user, $locationId);
            }
        }
        else {

            // Si no existe, creamos el usuario, lo guardamos en la base de datos y devolvemos el usuario creado, el token y el profile
            $user = new User($request->all());
            if (isset($user)) {
                $user->type = 'user';
                $user->save();
                $token = JWTAuth::fromUser($user);

                // Creamos su profile
                $profile = $this->createProfile($user, $locationId);

            }
        }
        return response()->json(['token' => $token, 'user' => $user, 'profile' => $profile]);
    }

    public function createProfile($user,$locationId)
    {
        // Y ahora su profile
        $profile = new UserProfile();
        $profile->user_id = $user->id;
        $profile->location_id = $locationId;
        $profile->mailregistered = $this->suscribeMail($locationId,$user);
        $profile->save();
        return $profile;
    }

    public function suscribeMail($location_id, $user)
    {
        $location = Location::findOrFail($location_id);
        $mail_registered = false;
        if (isset($location) && isset($location->maillist))
        {
            try {
                MailchimpFacade::subscribe($location->maillist, $user->email,['FNAME' => $user->name, 'LNAME' => ''],false);
                $mail_registered = true;
            } catch (MailchimpException $e) {
                // Log the error information for debugging
                Log::error('Mailchimp error:'.$e->getMessage());
                $mail_registered = false;
            }
        }
        return $mail_registered;

    }


    public function newIncidence(Request $request)
    {
        $incidence = new Incidence();
        //Log::info('New incidence');
        if (isset($incidence)) {
            $incidence->status = false;
            $incidence->location_id=$request->get('location');
            $incidence->coords=$request->get('coords');
            $incidence->user_email=$request->get('user');
            $incidence->attachment = $this->saveFile($request->file('file'),'attachment', $incidence->path);
            //Log::info('salvando:'.$request->file('file'));
            $incidence->save();
        }
        return response()->json($incidence);
    }

    public function saveFile($file,$name,$folder)
    {
        $filename = null;
        if (isset($file)) {
            $filename = $folder . '/' . $name .Carbon::now(). '.' . $file->getClientOriginalExtension();
            if (Storage::disk('s3')->put($filename, File::get($file),'public'))
                return Storage::disk('s3')->url($filename);
        }

        return $filename;
    }

    public function fileUpload(Request $request)
    {
        Log::info('entrando fileupload');
        try {
            $user = JWTAuth::toUser($request->input('token'));
            $profile = $user->locationProfile($request->input('location'));
            $filename = $this->saveFile($request->file('file'),'profile', $user->path);
            Log::info('$filename:'.$filename);
            Log::info('profile:'.$profile->id);
            if ($filename != $profile->avatar) {
                $profile->avatar = $filename;
                $profile->save();
            }
        } catch (Exception $e) {
                return response()->json($e->getMessage());
        }

        return response()->json($profile->avatar);
    }



    public function userUpdate(Request $request)
    {
        //Log::info('ENTRANDO userUpdate');
        try {
            $user = JWTAuth::toUser($request->input('token'));
            $name = $request->input('name');
            if (isset($name) && $name != '' ){
                $user->name = $name;
                $user->save();
            }
            $profile = $user->locationProfile($request->input('location'));
            $profile->phone = $request->input('phone');
            $profile->birth_date = $request->input('birthdate');
            $profile->save();

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($profile);
    }

    public function lastOffers(Request $request)
    {
        //Log::info('ENTRANDO lastOffers');
        $input = $request->all();
        $latitude = $input['latitude'];
        $longitude = $input['longitude'];
        $location = 1;
        if(isset($input['location']))
            $location = $input['location'];

        if ($latitude != -1 && $longitude != -1) {
             $query = 'SELECT ads.*,packs.id as packid  from advertisements ads
                JOIN adspacks packs ON
                packs.advertisement_id = ads.id AND
                packs.smallpack >0 AND
                packs.latitude BETWEEN (' . $latitude . ' - (packs.radio*0.0117)) AND (' . $latitude . ' + (packs.radio*0.0117)) AND
                packs.longitude BETWEEN (' . $longitude . ' - (packs.radio*0.0117)) AND (' . $longitude . ' + (packs.radio*0.0117))
                WHERE ads.location_id = '. $location .'
                ORDER BY CASE ads.id WHEN 16 THEN -1 ELSE RAND() END LIMIT 20';
        }
        else{
             $query = 'SELECT ads.*,packs.id as packid from advertisements ads
                      JOIN adspacks packs ON
                      packs.advertisement_id = ads.id AND
                      packs.smallpack >0
                      WHERE ads.location_id = '. $location. '
                      ORDER BY CASE ads.id WHEN 16 THEN -1 ELSE RAND() END LIMIT 20';
        }

        $offers = DB::select($query);
        return response()->json($offers);

    }


    public function messages(Request $request)
    {
        //Log::info('ENTRANDO messages');
        $input = $request->all();
        $location = $input['location'];
       /* try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }*/

        $now = Carbon::now()->toDateTimeString();

        $messages = DB::table('messages')
                        ->where('start','<',$now)
                        ->where('end','>',$now)
                        ->where('location_id',$location)
                        ->orderBy('end','asc')
                        ->get();

        return response()->json($messages);

    }


    public function globalRanking(Request $request)
    {
        //Log::info('ENTRANDO globalRanking');
        $input = $request->all();
        $location = $input['location'];

        /*
        $user_profiles =  UserProfile::where('location_id','=',$location)
            ->select('users.id','users.name as us_name','user_profiles.*')
            ->join('users','user_profiles.user_id','=','users.id')
            ->orderBy('points', 'desc')
            ->orderBy('name', 'asc')
            ->take(10)->get();*/
        $user_profiles =  UserProfile::globalRanking($location,false);

        return response()->json($user_profiles);
    }


    public function userGameboards(Request $request)
    {
        //Log::info('ENTRANDO userGameboards');
        $input = $request->all();
        $location = $input['location'];

        $usergameboards = DB::select( DB::raw("select a.user_id as id,gameboards.name as gb_name,users.name as us_name, a.points,a.gameboard_id, count(b.gameboard_id)+1 as ranking
                    from user_gameboards a
                    left join user_gameboards b on a.points < b.points and b.gameboard_id = a.gameboard_id
                    inner join gameboards on a.gameboard_id = gameboards.id
                    inner join users on a.user_id = users.id
                    where gameboards.location_id = :location and a.points>0 and gameboards.status <> " .Status::DISABLED.
                    " and gameboards.status < ".Status::HIDDEN.
                    " group by a.gameboard_id ,a.id,a.user_id
                    order by gameboards.deadline,a.gameboard_id asc, a.points desc, us_name asc"), array('location' => $location) );

        return response()->json($usergameboards);

    }

    private function monthlyQuery($location,$startcurrentmonth,$endcurrentmonth){
        //Log::info('ENTRANDO monthlyQuery');
        return "select users.id, users.name as name , sum(a.points) as points from
                                        user_gameboards a
                                        inner join gameboards on a.gameboard_id = gameboards.id "
            . " inner join users on a.user_id = users.id
                                        where a.points>0 and gameboards.status <> " .Status::DISABLED.

            " and a.updated_at >= '". $startcurrentmonth . "' and a.updated_at <= '" . $endcurrentmonth .
        "' and  gameboards.location_id = ". $location.
            " group by users.id order by points desc, name asc LIMIT 10";


    }

    public function monthlyRanking(Request $request)
    {
        //Log::info('ENTRANDO monthlyRanking');
        $input = $request->all();
        $location = $input['location'];
        setlocale(LC_TIME, 'es_ES');
        $startcurrentmonth = Carbon::now()->startofMonth();
        $endcurrentmonth = Carbon::now()->endofMonth();


        $query = $this->monthlyQuery($location,$startcurrentmonth,$endcurrentmonth);
        //Log::info('Monthly query:'.$query);

        $current = DB::select(DB::raw($query));

        // Previous month
        $startcurrentmonth = Carbon::now()->subMonth()->startofMonth();
        $endcurrentmonth = Carbon::now()->subMonth()->endofMonth();
        $query = $this->monthlyQuery($location,$startcurrentmonth,$endcurrentmonth);
        $prev = DB::select(DB::raw($query));


        return response()->json(['ranking'=>$current, 'month'=>Carbon::now()->formatLocalized('%B'),'preRanking'=>$prev, 'preMonth'=>Carbon::now()->subMonth()->formatLocalized('%B')]);

    }

}
