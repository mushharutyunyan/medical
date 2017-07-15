<?php
Route::get('admin/404','Admin\HomeController@notFound');
Route::get('admin/login','Admin\HomeController@login');
Route::post('admin/login','Admin\LoginController@login');
Route::get('admin/logout','Admin\LoginController@logout');
Route::group(['namespace' => 'Admin','prefix' => 'admin','middleware' => 'adminAuth'],function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::get('/','HomeController@home');
    Route::group(['middleware' => 'adminPermission'],function(){
        Route::resource('/storage','StorageController');
        Route::group(['prefix' => 'manage'],function(){
            Route::resource('/admins','AdminsController');
            Route::resource('/roles','RolesController');
            Route::resource('/drugs','DrugsController');
            Route::resource('/organizations','OrganizationsController');
            Route::get('/admins/{id}/changePassword','AdminsController@changePassword');
        });
        Route::group(['prefix' => 'storage'],function(){
            Route::post('/searchDrug','StorageController@searchDrug');
            Route::post('/searchDrugSettings','StorageController@searchDrugSettings');
            Route::post('/checkDrug','StorageController@checkDrug');
            Route::post('/save','StorageController@save');
            Route::post('/saveAll','StorageController@saveAll');
        });
    });
});