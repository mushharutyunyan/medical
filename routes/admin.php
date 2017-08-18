<?php
Route::get('admin/404','Admin\HomeController@notFound');
Route::get('admin/login','Admin\HomeController@login');
Route::post('admin/login','Admin\LoginController@login');
Route::get('admin/logout','Admin\LoginController@logout');
Route::group(['namespace' => 'Admin','prefix' => 'admin','middleware' => 'globalAdmin'],function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    Route::group(['middleware' => 'adminAuth'],function(){
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
        });
    });
    Route::group(['prefix' => 'storage'],function(){
        Route::post('/searchDrug','StorageController@searchDrug');
        Route::post('/searchDrugSettings','StorageController@searchDrugSettings');
        Route::post('/checkDrug','StorageController@checkDrug');
        Route::post('/save','StorageController@save');
        Route::post('/saveAll','StorageController@saveAll');
    });

    Route::resource('/order','OrderController');
    Route::group(['prefix' => 'order'],function(){
        Route::get('/messages/{order_id}','OrderController@messages');
        Route::post('/changeStatus','OrderController@changeStatus');
        Route::post('/getAnswerStatuses','OrderController@getAnswerStatuses');
        Route::post('/getDeliveryStatuses','OrderController@getDeliveryStatuses');
        Route::post('/changeStatusTo','OrderController@changeStatusTo');
        Route::post('/changeOrganization','OrderController@changeOrganization');
        Route::get('/excel/get','OrderController@excelFiles');
        Route::get('/excel/download/{file}','OrderController@excelDownload');
        Route::post('/changeStatus/received','OrderController@receivedOrder');

    });
    Route::resource('/message','MessageController');
    Route::resource('/userOrder','UserOrderController');
    Route::get('/userOrder/details/delete','UserOrderController@deleteDetail');
    Route::post('/userOrder/details/save','UserOrderController@saveDetails');
    Route::get('/userOrder/{order_id}/{status}','UserOrderController@changeStatus');

});