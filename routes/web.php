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

Route::post('/generate','PagesController@generarExamen');

Route::get('/generate/word', 'PagesController@generarWordPregunta');

Route::get('/generate/answer', 'PagesController@generarWordRespuesta');

Route::get('/admin', 'PagesController@admin');

Route::post('/admin/create','AdminController@crearPregunta');

Route::get('/admin/show','AdminController@mostrarPregunta')->name('showComp');

Route::post('/admin/edit','AdminController@modificarPregunta');

Route::post('/admin/save','AdminController@guardarModificacion');

Route::post('/admin/erase','AdminController@borrarPregunta');

Route::post('/admin/validate','PagesController@esqComp');

#Route::post('/admin/show','AdminController@mostrarPregunta')#;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/
