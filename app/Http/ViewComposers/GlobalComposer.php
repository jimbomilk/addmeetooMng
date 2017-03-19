<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class GlobalComposer {

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    //protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        //$this->users = $users;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        //$view->with('count', $this->users->count());
        $view->with('login_user', Auth::user());
    }

}