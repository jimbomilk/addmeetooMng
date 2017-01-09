<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



$s = 'social.';
Route::get('/social/redirect/{provider}',   ['as' => $s . 'redirect',   'uses' => 'Auth\AuthController@getSocialRedirect']);
Route::get('/social/handle/{provider}',     ['as' => $s . 'handle',     'uses' => 'Auth\AuthController@getSocialHandle']);

Route::get('logout', function () {return redirect('auth/logout');});

Route::group(['prefix'=>'admin','middleware' => ['auth','is_admin'],'namespace'=>'admin'],function(){

    Route::resource('/', 'AdminController');




    // ** ADMIN  **
    Route::resource('users', 'UsersController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('locations', 'LocationsController');
    Route::resource('positions', 'PositionsController');
    Route::resource('activities', 'ActivitiesController');
    Route::resource('languages', 'LanguagesController');


    // ** AUCTIONS **
    Route::resource('items', 'ItemsController');
    Route::resource('auctions', 'AuctionsController');
    Route::resource('bids', 'BidsController');

    // ** TV SET **
    Route::resource('tvconfigs', 'TvConfigsController');
    Route::resource('screens', 'ScreensController');

});


Route::get ('home', function()
{
    return "Welcome to ADDMEETOO";
})->name('home');

/*
Route::group(['prefix'=>'api','namespace' => '\Api'],function(){

    //Route::get('login', 'LoginController@loginWithTwitter');

    //Route::get('activities', 'ApiController@indexActivities');
    //Route::get('auctions', 'ApiController@indexAuctions');
    //Route::get('auction/{id}', 'ApiController@indexAuction');
    //Route::get('auctionbid/{id}', 'ApiController@updateAuction');
    //  Route::get('persons', 'ApiController@persons');


});*/

