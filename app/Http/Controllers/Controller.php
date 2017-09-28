<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Mailchimp;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    public $login_user = null;
    public $mailchimp;

    public function __construct(\Mailchimp $mailchimp)
    {
        $login_user = Request::user();
        $this->mailchimp = $mailchimp;

        View::share('login_user', $login_user);

    }

    public function indexPage($name)
    {
        return Auth::user()->type.".".$name.".index";
    }
}
