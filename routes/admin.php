<?php
Route::get('admin/404','Admin\HomeController@notFound');
Route::get('admin/login','Admin\HomeController@login');
Route::post('admin/login','Admin\LoginController@login');
Route::get('admin/logout','Admin\LoginController@logout');
Route::group(['namespace' => 'Admin','prefix' => 'admin','middleware' => 'adminAuth'],function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::get('/','HomeController@home');
    Route::group(['prefix' => 'manage','middleware' => 'adminPermission'],function(){
        Route::resource('/admins','AdminsController');
        Route::resource('/roles','RolesController');
        Route::resource('/drugs','DrugsController');
        Route::resource('/organizations','OrganizationsController');
        Route::get('/admins/{id}/changePassword','AdminsController@changePassword');
    });
});