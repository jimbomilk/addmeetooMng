<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        //$view->with('count', $this->users->count());


        $this->registerPolicies($gate);
        view()->composer('*', function($view){
            $user = Auth()->user();
            if (isset($user)){
                $profile = $user->profiles()->first();
                $view->with('profile',$profile);
            }
            $view->with('login_user', $user);

        });
        //
    }
}
