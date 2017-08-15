<?php

namespace App\Http\Controllers\Api;

use App\Adspack;
use App\Events\Envelope;
use App\Events\MessageEvent;
use App\Gameboard;
use App\Status;
use App\User;
use App\UserGameboard;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Tymon\JWTAuth\Facades\JWTAuth;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function persons()
    {

    }

    public function saveFile($file,$name,$folder)
    {
        $filename = null;
        if (isset($file)) {
            $filename = $folder . '/' . $name ;
            Storage::disk('local')->put($filename, File::get($file));
        }

        return $filename;
    }


    public function gameboard($gameboard_id, Request $request)
    {
        $input = $request->all();
        try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $gameboard = Gameboard::findOrFail($gameboard_id);
            if (!$gameboard->participation_status)
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
            if (!$gameboard->participation_status)
                return response()->json(['error' => "GAME CLOSED: $gameboard_id"], HttpResponse::HTTP_UNAUTHORIZED);
        } catch (Exception $e) {
            return response()->json(['error' => "GAME NOT FOUND: $gameboard_id"], HttpResponse::HTTP_NOT_FOUND);
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


        // GUARDAMOS PUNTOS y RECALCULAMOS TOP RANK
        if (!$second) {
            $result->points = $result->points + + $gameboard->activity->reward_participation;
            $user->profile->points = $user->profile->points + $gameboard->activity->reward_participation;
            $user->profile->save();
            $user->profile->recalculateTopRank();

        }
        $result->values = json_encode($values);

        $result->save();

        // A pantalla
        $message = new Envelope();
        $message->stext = strtoupper($user->name);
        $message->ltext = $gameboard->name;
        $message->type = 'message';
        $message->image = $user->profile->avatar;
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
            $gameboards = Gameboard::where('location_id', $location_id)->get();
        }
        else
            $gameboards = Gameboard::all();
        $now = Carbon::now(Config::get('app.timezone'));
        $gameviews = array();
        foreach($gameboards as $gameboard)
        {
            $start = Carbon::parse($gameboard->startgame); //en UTC
            $end = Carbon::parse($gameboard->endgame);

            //Log::info('now1:'.$now.' start:'.$start.' end:'.$end);
            if ($now>$start && $now<$end){

                $gameview = $gameboard->getGameView();
                if (isset($gameview))
                    $gameviews[] = $gameview;
            }
        }
        return json_encode($gameviews);



    }


    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['result' => 'wrong email or password.']);
        }
        $user = JWTAuth::toUser($token);

        return response()->json(['token' => $token, 'user' => $user, 'profile' => $user->profile]);

    }


    public function newAccount(Request $request)
    {
        // Recogemos las credenciales
        $credentials = $request->only('email', 'password');


        // Vemos si existe en la base de datos. Si existe , damos error
        if ($token = JWTAuth::attempt($credentials) ||  User::where('email',$credentials['email'])->first()!= null) {
            return response()->json(['result' => 'El usuario ya existe.']);
        }

        // Si no existe, creamos el usuario, lo guardamos en la base de datos y devolvemos el usuario creado, el token y el profile
        $user = new User($request->all());

        if (isset($user)) {
            $token = JWTAuth::fromUser($user);
            $user->type = 'user';
            $user->save();
            $profile = new UserProfile();
            $profile->user_id = $user->id;
            $profile->location_id = $request->get('location');
            $profile->save();
        }
        return response()->json(['token' => $token, 'user' => $user, 'profile' => $user->profile]);
    }


    public function fileUpload(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            $filename = $request->saveFile('profile', $user->path);
            if ($filename != $user->profile->avatar) {
                $user->profile->avatar = $filename;
                $user->profile->save();
            }
        } catch (Exception $e) {
                return response()->json($e->getMessage());
        }

        return response()->json($user->profile->avatar);
    }

    public function userUpdate(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            $user->profile->phone = $request->input('phone');
            $user->profile->birth_date = $request->input('birthdate');
            //Log::info('Birth:'.$user->profile->birth_date);
            $user->profile->save();

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($user->profile);
    }

    public function lastOffers(Request $request)
    {
        $input = $request->all();
        $latitude = $input['latitude'];
        $longitude = $input['longitude'];
        /*try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }*/

        if ($latitude != -1 && $longitude != -1) {
            $query = 'SELECT * from advertisements ads
                    JOIN adspacks packs ON
                        packs.advertisement_id = ads.id AND
                        packs.latitude BETWEEN (' . $latitude . ' - (packs.radio*0.0117)) AND (' . $latitude . ' + (packs.radio*0.0117)) AND
                        packs.longitude BETWEEN (' . $longitude . ' - (packs.radio*0.0117)) AND (' . $longitude . ' + (packs.radio*0.0117))
                    ORDER BY packs.updated_at DESC
                    LIMIT 5';
        }
        else{
            $query = 'SELECT * from advertisements ads
                      ORDER BY RAND()
                      LIMIT 5';
        }

        $offers = DB::select($query);
        return response()->json($offers);

    }


    public function messages(Request $request)
    {
        $input = $request->all();
        $location = $input['location'];
       /* try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }*/

        $now = Carbon::now()->toDateTimeString();

        $messages = DB::table('messages')
                        ->where('end','>',$now)
                        ->orWhere('location_id',$location)
                        ->orderBy('stext','asc')
                        ->get();

        return response()->json($messages);

    }


    public function globalRanking(Request $request)
    {
        $input = $request->all();
        $location = $input['location'];
        try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $user_profiles =  UserProfile::where('location_id','=',$location)
            ->select('users.name as us_name','user_profiles.*')
            ->join('users','user_profiles.user_id','=','users.id')
            ->orderBy('points', 'desc')
            ->take(10)->get();

        return response()->json($user_profiles);

    }

    public function userGameboards(Request $request)
    {
        $input = $request->all();
        $location = $input['location'];
        try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        /*$usergameboards = DB::table('user_gameboards a')
            ->select('gameboards.name as gb_name', 'users.name as us_name','a.*','count (b.gameboard_id)+1 as ranking' )
            ->leftJoin('user_gameboards b','a.points', '>','b.points')
            ->join('gameboards', 'a.gameboard_id', '=', 'gameboards.id')
            ->join('users','a.user_id','=','users.id')
            ->where('gameboards.location_id','=',$location)
            ->orderBy('a.gameboard_id', 'asc')
            ->orderBy('a.points', 'desc')
            ->groupBy('a.gameboard_id')
            ->toSql();*/




        $usergameboards = DB::select( DB::raw("select gameboards.name as gb_name,users.name as us_name, a.points,a.gameboard_id, count(b.gameboard_id)+1 as ranking
                    from user_gameboards a
                    left join user_gameboards b on a.points < b.points and b.gameboard_id = a.gameboard_id
                    inner join gameboards on a.gameboard_id = gameboards.id
                    inner join users on a.user_id = users.id
                    where gameboards.location_id = :location
                    group by a.gameboard_id ,a.id
                    order by a.gameboard_id asc, a.points desc, us_name asc"), array('location' => $location) );

        return response()->json($usergameboards);

    }



}
