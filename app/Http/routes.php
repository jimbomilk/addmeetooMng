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
	'auth' => '\App\Http\Controllers\Auth\AuthController',
	'password' => '\App\Http\Controllers\Auth\PasswordController',
]);

Route::group(['prefix'=>'admin','middleware' => ['auth','is_admin'],'namespace' => '\Admin'],function(){

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


Route::get('/', function()
{
    return "Welcome to ADDMEETOO";
});


Route::group(['prefix'=>'api','namespace' => '\Api'],function(){

    /*Route::get('login', 'LoginController@loginWithTwitter');

    Route::get('activities', 'ApiController@indexActivities');
    Route::get('auctions', 'ApiController@indexAuctions');
    Route::get('auction/{id}', 'ApiController@indexAuction');
    Route::get('auctionbid/{id}', 'ApiController@updateAuction');
*/
    Route::get('persons', 'ApiController@persons');


});