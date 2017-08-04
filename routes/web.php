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
Route::get('/','HomeController@index');
Route::get('/search','HomeController@search');
Route::get('/language/{language}',['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


//ORDER routes
Route::group(['prefix' => 'order'],function(){
    Route::post('/basket/add','OrderController@addBasket');
    Route::post('/basket/delete','OrderController@deleteBasket');
    Route::post('/basket/update','OrderController@updateBasket');
    Route::get('/cart','OrderController@cart');
});


Route::group(['middleware' => 'user'],function(){
    Route::get('/account','HomeController@account');
    Route::put('/account/update/{id}','HomeController@accountUpdate');
});



