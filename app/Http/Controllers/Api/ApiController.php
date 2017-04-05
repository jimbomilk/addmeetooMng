<?php

namespace App\Http\Controllers\Api;

use App\Events\Envelope;
use App\Events\MessageEvent;
use App\Gameboard;
use App\UserGameboard;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Requests;
use App\Http\Controllers\Controller;




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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function persons()
    {
        
    }

    // Devuelve el game activo en este instante , y si no hay ninguno retorna el game_board siguiente
    public function active_game($location_id)
    {

        return Gameboard::where('status', '=', 'running', 'and' ,'location_id', '=', $location_id )->firstOrFail();

    }

    public function screens($location_id,$screen_id, Request $request)
    {
        $gameboard = $this->active_game($location_id);

        if (isset($gameboard))
        {
            return json_encode($gameboard->gameViews);

        }

    }

    public function screen($id, Request $request)
    {

        try {
            $screen = Screen::findOrFail($id);
        } catch (Exception $e) {
            return response()->json(['error' => "Screen NOT FOUND: $id"],HttpResponse::HTTP_NOT_FOUND );
        }

        $input = $request->all();
        try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }
        return json_encode($screen);
    }


    public function gameboard($gameboard_id, Request $request)
    {
        try {
            $gameboard = Gameboard::findOrFail($gameboard_id);
        } catch (Exception $e) {
            return response()->json(['error' => "Game NOT FOUND: $gameboard_id"],HttpResponse::HTTP_NOT_FOUND );
        }

        $input = $request->all();
        try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
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

    public function useroptions($gameboard_id,Request $request)
    {
        $input = $request->all();
        try {
            $gameboard = Gameboard::findOrFail($gameboard_id);
        } catch (Exception $e) {
            return response()->json(['error' => "Game NOT FOUND: $gameboard_id"],HttpResponse::HTTP_NOT_FOUND );
        }


        try {
            $user = JWTAuth::toUser($input['token']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $values = $input['values'];
        // Guardar las opciones, generar un mensaje para la pantalla y responder OK

        $result = UserGameboard::firstOrNew (['gameboard_id'=>$gameboard_id,'user_id'=>$user->id]);
        $result->values = json_encode($values);
        $result->save();

        $message = new Envelope();
        $message->setText($user->name,$values);
        $message->image = $user->profile->avatar;
        $message->reward = $gameboard->activity->reward_participation;


        // A pantalla
        event(new MessageEvent($message, 'location2'/*.$gameboard->location_id*/));

        // Mensaje

        return json_encode($message);
    }



    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['result' => 'wrong email or password.']);
        }
        $user = JWTAuth::toUser($token);

        return response()->json(['token' => $token,'user' => $user, 'profile' => $user->profile]);

    }
}
