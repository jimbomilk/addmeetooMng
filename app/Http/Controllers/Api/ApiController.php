<?php

namespace App\Http\Controllers\Api;

use App\Adspack;
use App\Events\Envelope;
use App\Events\MessageEvent;
use App\Gameboard;
use App\User;
use App\UserGameboard;
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
        $result->values = json_encode($values);

        $result->save();

        // A pantalla
        $message = new Envelope();
        $message->stext = $gameboard->name;
        $message->ltext = strtoupper('Gracias '.$user->name." por participar");
        $message->image = $user->profile->avatar;
        event(new MessageEvent($message, 'location'.$gameboard->location_id));

        // A movil
        $message->setText($user->name, $values);
        $message->reward = $gameboard->activity->reward_participation;
        return json_encode($message);
    }


    // Devuelve todos los gameboards activos para el día de hoy
    public function gameboards()
    {
        $gameboards = Gameboard::all();
        $now = Carbon::now(Config::get('app.timezone'));

        $gameviews = array();
        foreach($gameboards as $gameboard)
        {
            $start = Carbon::parse($gameboard->startgame); //en UTC
            $end = Carbon::parse($gameboard->endgame);

            if ($now>$start && $now<$end){
                Log::info('now1:'.$now.' start:'.$start.' end:'.$end);
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
        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json(['result' => 'El usuario ya existe.']);
        }

        // Si no existe, creamos el usuario, lo guardamos en la base de datos y devolvemos el usuario creado, el token y el profile
        $user = new User($request->all());

        if (isset($user)) {
            $token = JWTAuth::fromUser($user);
            $user->type = 'user';
            $user->save();
        }

        return response()->json(['token' => $token, 'user' => $user, 'profile' => $user->profile]);

    }


    public function fileUpload(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            $filename = $this->saveFile($request->file('file'),$request->input('filename'), $user->path);
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
            Log::info('Birth:'.$user->profile->birth_date);
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
        try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $query = 'SELECT * from advertisements ads
                    JOIN adspacks packs ON
                        packs.advertisement_id = ads.id AND
                        packs.latitude BETWEEN ('.$latitude.' - (packs.radio*0.0117)) AND ('.$latitude.' + (packs.radio*0.0117)) AND
                        packs.longitude BETWEEN ('.$longitude.' - (packs.radio*0.0117)) AND ('.$longitude.' + (packs.radio*0.0117))
                    ORDER BY packs.updated_at DESC
                    LIMIT 5';

        $offers = DB::select($query);
        Log::info('Offers:'.$query);
        return response()->json($offers);

    }

}
