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

Route::get('/contact-us', 'ContactusController@index');
Route::post('/sendmail', 'MailController@send');
Route::post('/products/{id}', 'ProductsController@addComment');
Route::delete('/products/{id}', 'ProductsController@deleteComment');
Route::resource('/products', 'ProductsController');
Route::get('/{home?}', 'HomeController@index');


