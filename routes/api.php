<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'user' => 'API\UserController',
    'map' => 'API\MapController'
]);
// search input routes
Route::get('findUser', 'API\UserController@search');
Route::get('findMap', 'API\MapController@search');
// Orders
Route::get('getOrders', 'API\OrderController@index');
Route::get('findOrder', 'API\OrderController@search');
Route::put('setChecked/{id}', 'API\OrderController@setChecked');
Route::get('findUnChecked', 'API\OrderController@selectUnChecked');
Route::get('printOrder/{id}', 'API\OrderController@printOrder');
// Consultations
Route::get('getConsultations', 'API\ConsultationController@index');
Route::get('findConsultation', 'API\ConsultationController@search');
Route::put('setCheckedConsultation/{id}', 'API\ConsultationController@setChecked');
Route::get('findUnCheckedConsultations', 'API\ConsultationController@selectUnChecked');
Route::get('printConsultation/{id}', 'API\ConsultationController@printConsultation');
// Customers
Route::get('getCustomers', 'API\CustomerController@index');
Route::get('findCustomer', 'API\CustomerController@search');
