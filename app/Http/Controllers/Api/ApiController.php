<?php

namespace App\Http\Controllers\Api;

use App\Gameboard;
use Illuminate\Http\Request;
use JWTAuth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GameView;

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

/*
        try {
            $gameviews = DB::table('game_views')
                ->join('gameboards', 'game_views.gameboard_id', '=' , 'gameboards.id' )

                where('gameboards.location_id', '=', $location_id)->get();

        } catch (Exception $e) {
            return response()->json(['error' => "Screen NOT FOUND: $id"],HttpResponse::HTTP_NOT_FOUND );
        }

        $input = $request->all();
        try {
            JWTAuth::toUser($input['token']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }
        return json_encode($gameviews);
*/
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


    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['result' => 'wrong email or password.']);
        }
        return response()->json(['token' => $token]);

    }
}
