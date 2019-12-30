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

/*************Authentication Routes starts************/

Route::middleware('guest')->group(function () {
	Route::get('/', 'Auth\LoginController@loginform');
	Auth::routes();
});
Route::get('logout', 'Auth\LoginController@logout');

//Auth::routes(['login' => false]);
/*************Authentication Routes Ends************/

Route::middleware('auth')->group(function () {
	/*****************reports -  Routes starts********************/
	
	//Order list
	Route::get('reports/orders', 'Web\ReportOrderController@orders');
	Route::post('reports/orders_detail', 'Web\ReportOrderController@orders');
	Route::post('reports/orders_status_detail', 'Web\ReportOrderController@orders_status');
	Route::post('reports/orders_payment_detail', 'Web\ReportOrderController@orders_payment');
	Route::post('reports/orders_billing_detail', 'Web\ReportOrderController@orders_billing');
	Route::post('reports/orders_shipping_detail', 'Web\ReportOrderController@orders_shipping');
	Route::post('reports/orders_sidewidgets', 'Web\ReportOrderController@orders_sidewidgets');
	Route::post('reports/orders_charts', 'Web\ReportOrderController@orders_charts');
	Route::post('reports/orders_customer_type_detail', 'Web\ReportOrderController@orders_customer_type_detail');
});
