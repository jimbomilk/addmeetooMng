<?php

namespace App\Http\Controllers\Admin;

use App\Gameboard;
use App\Incidence;
use App\Status;
use App\User;
use App\UserGameboard;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $incidences = Auth::user()->incidences()->paginate();
        $activityNumber = Auth::user()->activeGameboards()->count();
        $ads = Auth::user()->advertisements();
        if (Auth::user()->is('admin')) {
            $participantNumber = UserGameboard::All()->count();
            $users = User::All()->count();
            $participationChart = UserGameboard::getParticipationByDate('1');
        }
        else {
            $participationChart = UserGameboard::getParticipationByDate('1');
        }


		return view('admin.dashboard.main',['activityNumber'=>$activityNumber,'participantNumber'=>$participantNumber,'users'=>$users,'participationChart'=>$participationChart,'incidences'=>$incidences,'ads'=>$ads]);
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
}
