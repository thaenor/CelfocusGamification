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


//landing page
Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
  'logout' => 'Auth\AuthController',
]);

//Resource routes
Route::resource('articles', 'ArticleController');
Route::resource('groups', 'GroupController');
Route::resource('leagues', 'LeagueController');
Route::resource('rewards', 'RewardController');
//Route::resource('users', 'UserController');
Route::resource('tickets', 'TicketController');

Route::group(array('prefix' => 'secretRoute'), function()
{
    Route::get('FranciscoSantos-oGajoDeCalcoes', function()
    {
        return view('secretRoute.pacman.pacman');
    });
});

Route::get('settings',['middleware' => 'auth','uses' => 'SettingsController@index']);
Route::post('settings/storepoints',['middleware' => 'auth','uses' => 'SettingsController@storePoints']);
Route::post('settings/storeblacklist',['middleware' => 'auth','uses' => 'SettingsController@storeBlackList']);

//API routes, suitable to be called through ajax
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::get('openTickets/{start}&{end}', 'ApiController@fetchOpenTicketJson');
    Route::get('closedTickets/{start}&{end}','ApiController@fetchClosedTicketJson');
    Route::get('reOpenedTickets/{start}&{end}','ApiController@fetchReOpenedTicketJson');

    Route::get('openTickets', 'ApiController@fetchOpenTicketJsonDefault');
    Route::get('closedTickets', 'ApiController@fetchClosedTicketJsonDefault');
    Route::get('reOpenedTickets', 'ApiController@fetchReopenedTicketJsonDefault');

    Route::get('groups', 'ApiController@fetchGroupJson');
    Route::get('articles', 'ApiController@fetchArticles');
    Route::get('getChallengesCount', 'ApiController@getChallengesCount');
    Route::get('getPointSettings', 'ApiController@getPointSettings');
});
