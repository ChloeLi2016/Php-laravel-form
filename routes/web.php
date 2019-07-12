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

Route::get('/', 'PagesController@home');
Route::get('/about', 'PagesController@about');

Route::get('/contact', 'TicketsController@create');
Route::post('/contact', 'TicketsController@store');
Route::get('/login', function(){
	return view('login');
});

Route::get('/test', function(){

	$flights = App\DepartmentDDA::all();
	var_dump($flights);
	
});

//stationery form action
Route::get('/StationeryForm', 'StationeryController@create')->middleware('auth');
Route::post('/StationeryForm','StationeryController@store');
Route::post('form/fetch','StationeryController@fetch');
Route::post('/form/getItems','StationeryController@items');
Route::post('/form/getUnit','StationeryController@unitOfMeasure');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
