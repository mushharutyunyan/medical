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
                Route::resource('/topRated','TopRatedDrugs');
                Route::get('/drugs/search','DrugsController@search');
                Route::post('/drugs/search','DrugsController@search');
                Route::resource('/drugs','DrugsController');
                Route::resource('/organizations','OrganizationsController');
                Route::get('/admins/{id}/changePassword','AdminsController@changePassword');
                Route::group(['prefix' => 'circulation'],function(){
                    Route::get('/','CirculationController@index');
                    Route::post('/','CirculationController@index');
                });
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
        Route::post('/getReceivedInfo','OrderController@getReceivedInfo');
        Route::get('/priceAndDiscount/get','OrderController@getPriceAndDiscount');
        Route::get('/discount/info','OrderController@discountInfo');
        Route::post('/discount/update','OrderController@discountUpdate');
        Route::get('/excel/get','OrderController@excelFiles');
        Route::get('/excel/download/{file}','OrderController@excelDownload');
        Route::post('/changeStatus/received','OrderController@receivedOrder');
        Route::get('/release/{order_id}','OrderController@release');
    });
    Route::resource('/message','MessageController');
    Route::resource('/userOrder','UserOrderController');
    Route::group(['prefix' => 'userOrder'],function(){
        Route::group(['prefix' => 'release'],function(){
            Route::get('/{order_id}','UserOrderController@release');
        });
        Route::get('/details/delete','UserOrderController@deleteDetail');
        Route::post('/details/save','UserOrderController@saveDetails');
        Route::get('/details/finishOrder','UserOrderController@finishOrderDetails');
        Route::get('/{order_id}/finish/delivery','UserOrderController@delivery');
        Route::get('/{order_id}/{status}','UserOrderController@changeStatus');
        Route::post('/finish/{user_type}','UserOrderController@finishOrder');
    });
    Route::get('/tickets/','HomeController@tickets');


});