<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::group(['middleware' => 'globalUser'],function(){
    Route::get('/','HomeController@index');
    Route::get('/search','HomeController@search');
    Route::get('/contacts','HomeController@contact');
    Route::post('/ticket','HomeController@createTicket');
    Route::get('/search/{organization_id}','HomeController@searchByOrg');
    Route::get('/language/{language}',['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

    Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
    Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


    //ORDER routes
    Route::group(['prefix' => 'order'],function(){
        Route::post('/basket/add','OrderController@addBasket');
        Route::post('/basket/delete','OrderController@deleteBasket');
        Route::post('/basket/update','OrderController@updateBasket');
        Route::get('/cart','OrderController@cart');
        Route::get('/','OrderController@index');
        Route::get('/getOrganizations','OrderController@getOrganizations');
        Route::get('/checkout','OrderController@checkout');
        Route::get('/details','OrderController@details');
        Route::post('/details','OrderController@getDetails');
        Route::post('/details/search','OrderController@details');
        Route::post('/createMessage','OrderController@createMessage');
        Route::post('/getMessages','OrderController@getMessages');
        Route::post('/pay','OrderController@pay');
        Route::get('/info','OrderController@info');
        Route::post('/canceled','OrderController@canceled');
        Route::get('/rank/stars','OrderController@rank');
    });


    Route::group(['middleware' => 'user'],function(){
        Route::get('/account','HomeController@account');
        Route::put('/account/update/{id}','HomeController@accountUpdate');
    });
});



