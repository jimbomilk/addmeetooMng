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



// CORS
//header('Access-Control-Allow-Origin: http://localhost:4200');
//header('Access-Control-Allow-Credentials: true');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



$s = 'social.';
Route::get('/social/redirect/{provider}',   ['as' => $s . 'redirect',   'uses' => 'Auth\AuthController@getSocialRedirect']);
Route::get('/social/handle/{provider}',     ['as' => $s . 'handle',     'uses' => 'Auth\AuthController@getSocialHandle']);

Route::get('logout', function () {return redirect('auth/logout');});

// PARA ADMIN
Route::group(['prefix'=>'admin','middleware' => ['auth','is_admin'],'namespace'=>'admin'],function(){

    Route::resource('/', 'AdminController');


    // ** ADMIN  **
    Route::resource('users', 'UsersController');
    Route::resource('locations', 'LocationsController');
    //Route::resource('advertisements', 'AdvertisementController');

    // ** GAMES  **
    Route::resource('activities', 'ActivitiesController');
    Route::resource('activity_options', 'ActivityOptionsController');
    Route::post('activity_options/fastUpdate/{id}', ['as' => 'activity_option_fast', 'uses' => 'ActivityOptionsController@fastUpdate']);


    Route::resource('gameboards', 'GameboardsController');
    Route::resource('gameboard_options', 'GameboardOptionsController');
    Route::post('gameboard_options/fastUpdate/{id}', ['as' => 'gameboard_option_fast', 'uses' => 'GameboardOptionsController@fastUpdate']);


    // ** AUCTIONS **
    Route::resource('items', 'ItemsController');
    Route::resource('auctions', 'AuctionsController');
    Route::resource('bids', 'BidsController');

    // ** TV SET **
    Route::resource('tvconfigs', 'TvConfigsController');
    Route::resource('screens', 'ScreensController');

});


Route::group(['prefix'=>'owner','middleware' => ['auth','is_owner'],'namespace'=>'admin'],function(){

    Route::resource('/', 'AdminController');

    // ** LOCATIONS**
    Route::resource('locations', 'LocationsController');
    //Route::resource('advertisements', 'AdvertisementController');

    // ** GAMES  **
    Route::resource('gameboards', 'GameboardsController');


    // ** AUCTIONS **


    // ** SCREENS **


});



Route::get ('home', function()
{
    return "Welcome to ADDMEETOO";
})->name('home');



Route::group(['prefix'=>'api','middleware'=>['api','cors'], 'namespace' => '\Api'],function(){

    //Route::get('login', 'LoginController@loginWithTwitter');
    Route::post('authenticate','ApiController@authenticate');
    Route::post('screens/{location_id}/{screen_id}','ApiController@screens');


    //Route::get('auctions', 'ApiController@indexAuctions');
    //Route::get('auction/{id}', 'ApiController@indexAuction');
    //Route::get('auctionbid/{id}', 'ApiController@updateAuction');
    //  Route::get('persons', 'ApiController@persons');

    Route::get('images/{filename}', function ($filename)
    {
        $path = storage_path() . '/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });


});

