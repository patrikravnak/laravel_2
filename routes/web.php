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

Route::resource('posts', 'PostController');
Route::resource('admin', 'AdminController');

Route::get('profile/index/{user}',  ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
Route::patch('profile/{user}/update',  ['as' => 'profile.update', 'uses' => 'ProfileController@update']);

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/post/{id}', 'PostController@show')->name('posts.show');

Route::resource('comments', 'CommentsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
