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
/*************API******************/
Route::get('getCategory', 'APIController@getCategory');
Route::get('getItem_bycid', 'APIController@get_item_by_cid');
Route::get('getItem', 'APIController@get_item_by_id');

//User
Route::get('getlogin', 'APIController@getlogin');
Route::get('getregister', 'APIController@getregister');
Route::get('change_password', 'APIController@change_password');
Route::get('forgetp', 'APIController@forgetp'); //pass
Route::get('sendotp', 'APIController@sendotp'); //pass
Route::get('verify_otp', 'APIController@verify_otp');
Route::post('edit_profile', 'APIController@edit_profile');
//User

//Unit
Route::get('create_unit', 'APIController@create_unit');
Route::get('getallunit', 'APIController@getallunit');
Route::get('getunit', 'APIController@getunit');
Route::get('updateunit', 'APIController@updateunit');
Route::get('deleteunit', 'APIController@deleteunit');
//Unit

//Vehicle Request
Route::get('create_vehicle', 'APIController@create_vehicle');
Route::get('getallvehicle', 'APIController@getallvehicle');
Route::get('getvehicle', 'APIController@getvehicle');
Route::get('updatevehicle', 'APIController@updatevehicle');
Route::get('deletevehicle', 'APIController@deletevehicle');
//Vehicle Request

//petrol Request
Route::get('create_petrol', 'APIController@create_petrol');
Route::get('getallpetrol', 'APIController@getallpetrol');
Route::get('getallpetrolbyuser', 'APIController@getallpetrolbyuser');
Route::get('getpetrol', 'APIController@getpetrol');
Route::get('updatepetrol', 'APIController@updatepetrol');
Route::get('deletepetrol', 'APIController@deletepetrol');

Route::get('update_petrol_done', 'APIController@update_petrol_done');
//petrol Request

//Location Request
Route::get('create_location', 'APIController@create_location');
Route::get('getalllocation', 'APIController@getalllocation');
Route::get('getlocation', 'APIController@getlocation');
Route::get('updatelocation', 'APIController@updatelocation');
Route::get('deletelocation', 'APIController@deletelocation');
//Location Request

//Material Request
Route::get('create_material', 'APIController@create_material');
Route::get('getallmaterials', 'APIController@getallmaterials');
Route::get('getmaterial', 'APIController@getmaterial');
Route::get('updatematerial', 'APIController@updatematerial');
Route::get('deletematerial', 'APIController@deletematerial');

Route::get('getallvehicleloaded', 'APIController@getallvehicleloaded');
Route::get('getallvehicleunloaded', 'APIController@getallvehicleunloaded');

//Material Request

//Material Type Request
Route::get('create_material_type', 'APIController@create_material_type');
Route::get('getallmaterials_type', 'APIController@getallmaterials_type');
Route::get('getallmaterials_type_mid', 'APIController@getallmaterials_type_mid');
Route::get('getmaterial_type', 'APIController@getmaterial_type');
Route::get('updatematerial_type', 'APIController@updatematerial_type');
Route::get('deletematerial_type', 'APIController@deletematerial_type');
//Material Type Request

//Client Request
Route::post('client_request', 'APIController@client_request_create');
Route::get('getclient_request', 'APIController@getclient_request');
Route::post('client_unload', 'APIController@client_unload_create');
Route::get('getclient_unload', 'APIController@getclient_unload');


Route::get('switch_vehicle', 'APIController@switch_vehicle');
//Client Request

//Manager/Supervisor Request
Route::post('manager_load', 'APIController@manager_request_create');
Route::get('getLoaded_items_by_v_no', 'APIController@getLoaded_items_by_v_no');
Route::get('getLoaded_items_by_vehicle_id', 'APIController@getLoaded_items_by_vehicle_id');
Route::get('getmanager_load', 'APIController@getmanager_request');
//Manager/Supervisor Request

//Staff Request
Route::get('getAllmanager_load', 'APIController@getAllmanager_request');
Route::get('getAllclient_request', 'APIController@getAllclient_request');
Route::get('getAllclient_unload', 'APIController@getAllclient_unload');
Route::get('getLoaded_request', 'APIController@getLoaded_request');
Route::get('getUnloaded_request', 'APIController@getUnloaded_request');
Route::get('getAllClient_requests', 'APIController@getAllClient_requests');
Route::get('getCompareList', 'APIController@getCompareList');
//Staff Request
/*************API******************/

/****************Bijendra*****************/
///////////////////////////////admin/////////////////////////////////////////////////////////////////////////////////////////
Route::get('/', 'AdminController@adminlogin');
Route::get('/admin', 'AdminController@admin');
Route::get('/logincheck', 'AdminController@logincheck');
Route::GET('logoutadmin', function () {
    session_start();
    $_SESSION['admin_master'] = null;
    return redirect('/');
});
//Web Admin
Route::post('change_password', 'AdminController@change_password');
Route::get('loaded_items', 'AdminController@loaded_items');
Route::get('loaded_items/{id}/delete', 'AdminController@delete_loaded_items');
Route::get('edit_loaded/{id}', 'AdminController@edit_loaded_items');
Route::post('update_loaded', 'AdminController@update_loaded_items');

Route::get('edit_unloaded/{id}', 'AdminController@edit_unloaded_items');
Route::post('update_unloaded', 'AdminController@update_unloaded_items');


Route::post('loaded_items_delete', 'AdminController@delete_loaded_items');
Route::post('unloaded_items_delete', 'AdminController@delete_unloaded_items');
Route::get('unloaded_items/{id}/delete', 'AdminController@delete_unloaded_items');
Route::post('loaded_items', 'AdminController@search_loaded_items');
Route::get('unloaded_items', 'AdminController@unloaded_items');
Route::post('unloaded_items', 'AdminController@search_unloaded_items');
Route::get('client_requests', 'AdminController@client_request_list');
Route::get('comparision', 'AdminController@material_comparision');
Route::get('petrol_requests', 'AdminController@petrol_requests');

Route::get('client_request/{id}/approved', 'AdminController@approved');

/**************Masters*****************/
//Unit
Route::resource('unit', 'UnitController');
Route::get('unit/{id}/delete', 'UnitController@destroy');
//Unit

//Material
Route::resource('material', 'MaterialController');
Route::get('material/{id}/delete', 'MaterialController@destroy');
//Material

//Material Type
Route::resource('material_type', 'MaterialTypeController');
Route::get('material_type/{id}/delete', 'MaterialTypeController@destroy');
//Material Type

//Vehicle
Route::resource('vehicle', 'VehicleController');
Route::get('vehicle/{id}/delete', 'VehicleController@destroy');
//Vehicle

//Location
Route::resource('location', 'LocationController');
Route::get('location/{id}/delete', 'LocationController@destroy');
//Location


//Location
Route::get('users', 'AdminController@users');
Route::get('users/{id}/active', 'AdminController@active');
Route::get('users/{id}/inactive', 'AdminController@inactive');
Route::get('users/{id}/edit', 'AdminController@edit_user');
Route::post('update_user', 'AdminController@update_user');
//Location
/**************Masters*****************/

//Web Admin

/****************Bijendra*****************/


