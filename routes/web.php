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
        return view('dashboard');
    })->name('dashboard');

    Route::get('/home',  'RequestEntriesController@get_data');
    Route::get('/api/documentrequest', 'RequestEntriesController@get_data');

    /* Route::get('/document', 'PagesController@documentRequest')->name('document'); */

    //Users
    Route::resource('users', 'UsersController');

    //Request Entry
    Route::get('documentrequest', 'RequestEntriesController@index')->name('documentrequest');
    //Route::put('/documentrequest', 'RequestEntriesController@index')->name('documentrequest');
    Route::post('documentrequest/iso/store', 'RequestEntriesController@store_iso');
    Route::post('documentrequest/legal/store', 'RequestEntriesController@store_legal');
    Route::put('documentrequest/{id}', 'RequestEntriesController@update');
    Route::post('documentrequest/requesthistory/iso/{id}', 'RequestEntriesController@history_iso');
    Route::post('documentrequest/requesthistory/legal/{id}', 'RequestEntriesController@history_legal');
    Route::get('requestentryhistory', 'RequestEntryHistoriesController@index');
    Route::post('requestentryhistory/store', 'RequestEntryHistoriesController@store');

    

    Route::post('showRequestEntry', 'RequestEntriesController@show');

    
    //Document Library
    Route::get('documentlibrary', 'DocumentLibrariesController@index')->name('documentlibrary');
    Route::post('documentlibrary/store', 'DocumentLibrariesController@store');
    
});