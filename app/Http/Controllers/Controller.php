<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public $login_user = null;

    public function __construct()
    {
        $login_user = Request::user();
        //

        View::share('login_user', $login_user);
        //View::share('profile', $profile);

    }

    public function indexPage($name)
    {
        return Auth::user()->type.".".$name.".index";
    }

    public function monthlyRank($location,$startcurrentmonth,$endcurrentmonth){
        return "select users.id, users.name as name, users.email , sum(a.points) as points".
                " from user_gameboards a".
                " inner join gameboards on a.gameboard_id = gameboards.id".
                " inner join users on a.user_id = users.id".
                " where a.points>0 and gameboards.status <> " .Status::DISABLED.
                " and a.updated_at >= '". $startcurrentmonth . "' and a.updated_at <= '" . $endcurrentmonth . "'".
                " and gameboards.location_id = ". $location.
                " group by users.id order by points desc, name asc";


    }
}
