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

function imageFile($path, $file)
{
    $path = storage_path('/app/public/').$path.'/'. $file;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
}

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



$s = 'social.';
Route::get('/social/redirect/{provider}',   ['as' => $s . 'redirect',   'uses' => 'Auth\AuthController@getSocialRedirect']);
Route::get('/social/handle/{provider}',     ['as' => $s . 'handle',     'uses' => 'Auth\AuthController@getSocialHandle']);

Route::get('logout', function () {return redirect('auth/logout');});

// PARA ADMIN
Route::group(['prefix'=>'admin','middleware' => ['auth','is_admin'],'namespace'=>'Admin'],function(){

    Route::resource('/', 'AdminController');


    // ** ADMIN  **
    Route::resource('users', 'UsersController');
    Route::resource('userprofiles', 'UserProfilesController');
    Route::resource('locations', 'LocationsController');
    Route::resource('messages', 'MessagesController');



    // ** ADS **
    Route::resource('advertisements', 'AdvertisementsController');
    Route::resource('adspacks', 'AdsPacksController');


    // ** GAMES  **
    Route::resource('activities', 'ActivitiesController');
    Route::resource('activity_options', 'ActivityOptionsController');
    Route::post('activity_options/fastUpdate/{id}', ['as' => 'activity_option_fast', 'uses' => 'ActivityOptionsController@fastUpdate']);
    Route::resource('gameboards', 'GameboardsController');
    Route::post('gameboards/fastUpdate/{id}', ['as' => 'admin.gameboard_fast', 'uses' => 'GameboardsController@fastUpdate']);
    Route::resource('gameboard_options', 'GameboardOptionsController');
    Route::post('gameboard_options/fastUpdate/{id}', ['as' => 'admin.gameboard_option_fast', 'uses' => 'GameboardOptionsController@fastUpdate']);
    Route::post('locations/restart/{location}',['as' => 'location_restart', 'uses' => 'LocationsController@restart']);

    Route::resource('usergameboards','UserGameboardsController');

    Route::post('gameboards/preview/{id}',['as'=>'gameboards_preview', 'uses' => 'GameboardsController@preview']);
    Route::post('gameboard_options/saveall',['as'=>'admin.gameboard_options.saveall','uses'=>'GameboardOptionsController@saveAll']);


    // ** AUCTIONS **
    Route::resource('items', 'ItemsController');
    Route::resource('auctions', 'AuctionsController');
    Route::resource('bids', 'BidsController');


    // INCIDENCES
    Route::post('incidences/fastUpdate/{id}', ['as' => 'admin.incidence_fast', 'uses' => 'IncidencesController@fastUpdate']);


    // MAILCHIMP
    Route::get('manageMailChimp', 'MailChimpController@manageMailChimp');
    Route::post('subscribe',['as'=>'subscribe','uses'=>'MailChimpController@subscribe']);
    //Route::post('sendCompaign',['as'=>'sendCompaign','uses'=>'MailChimpController@sendCompaign']);

});


Route::group(['prefix'=>'owner','middleware' => ['auth','is_owner'],'namespace'=>'Admin'],function(){

    Route::resource('/', 'AdminController');

    // ** GESTION**
    Route::resource('locations', 'LocationsController');
    Route::resource('messages', 'MessagesController');

    // ** GAMES  **
    Route::resource('gameboards', 'GameboardsController');
    Route::post('gameboards/fastUpdate/{id}', ['as' => 'owner.gameboard_fast', 'uses' => 'GameboardsController@fastUpdate']);
    Route::resource('gameboard_options', 'GameboardOptionsController');
    Route::post('gameboard_options/fastUpdate/{id}', ['as' => 'owner.gameboard_option_fast', 'uses' => 'GameboardOptionsController@fastUpdate']);

    // ** RANKING **
    Route::resource('usergameboards','UserGameboardsController');

    // ** ADS **
    Route::resource('advertisements', 'AdvertisementsController');
    Route::resource('adspacks', 'AdsPacksController');

    // INCIDENCES
    Route::post('incidences/fastUpdate/{id}', ['as' => 'owner.incidence_fast', 'uses' => 'IncidencesController@fastUpdate']);



});

Route::group(['prefix'=>'user','middleware' => ['auth','is_user'],'namespace'=>'Admin'],function(){

    Route::resource('/', 'AdminController');

    // ** ADS **
    Route::resource('advertisements', 'AdvertisementsController');
    Route::resource('adspacks', 'AdsPacksController');

});


Route::get ('/', function()
{
    return redirect()->away('http://www.addmeetoo.es');
});



Route::group(['prefix'=>'api','middleware'=>['api','cors'], 'namespace' => '\Api'],function(){

    //Route::get('login', 'LoginController@loginWithTwitter');
    Route::post('authenticate','ApiController@authenticate');
    Route::post('newAccount','ApiController@newAccount');
    Route::post('forgot', 'Auth\AuthController@forgot');
    Route::post('reset', 'Auth\AuthController@reset');
    Route::post('registerDevicePush', 'ApiController@registerDevicePush');

    Route::post('gameboard/{gameboard_id}','ApiController@gameboard');
    Route::post('gameinfo/{gameboard_id}','ApiController@gameinfo');
    Route::post('gameboard/useroptions/{gameboard_id}','ApiController@useroptions');
    Route::post('gameboards','ApiController@gameboards'); // Pantalla eventos de los moviles
    Route::post('fileupload','ApiController@fileUpload');
    Route::post('userUpdate','ApiController@userUpdate');
    Route::post('lastOffers','ApiController@lastOffers');
    Route::post('messages','ApiController@messages');
    Route::post('newIncidence','ApiController@newIncidence');

    Route::post('globalRanking','ApiController@globalRanking');
    Route::post('gamesRanking','ApiController@userGameboards');
    Route::post('monthlyRanking','ApiController@monthlyRanking');


    //Route::get('auctions', 'ApiController@indexAuctions');
    //Route::get('auction/{id}', 'ApiController@indexAuction');
    //Route::get('auctionbid/{id}', 'ApiController@updateAuction');
    //Route::get('persons', 'ApiController@persons');



});



