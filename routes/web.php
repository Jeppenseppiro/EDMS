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


//Route::get('/users', 'PagesController@usersView')->name('users');

Route::group( ['middleware' => 'auth'], function(){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home',  'RequestEntriesController@get_data');
    Route::get('/api/documentrequest', 'RequestEntriesController@get_data');

    /* Route::get('/document', 'PagesController@documentRequest')->name('document'); */

    //Users
    Route::resource('users', 'UsersController');

    //Request Entry
    Route::get('documentrequest', 'RequestIsoEntriesController@index')->name('documentrequest');
    //Route::put('/documentrequest', 'RequestIsoEntriesController@index')->name('documentrequest');
    Route::post('documentrequest/store', 'RequestIsoEntriesController@store');
    Route::put('documentrequest/{id}', 'RequestIsoEntriesController@update');
    Route::post('documentrequest/requesthistory/{id}', 'RequestIsoEntriesController@history');
    Route::get('requestentryhistory', 'RequestIsoEntryHistoriesController@index');
    Route::post('requestentryhistory/store', 'RequestIsoEntryHistoriesController@store');

    Route::post('showRequestEntry', 'RequestIsoEntriesController@show');

    
    //Document Library
    Route::get('documentlibrary', 'DocumentLibrariesController@index')->name('documentlibrary');
    Route::post('documentlibrary/store', 'DocumentLibrariesController@store');
    
});