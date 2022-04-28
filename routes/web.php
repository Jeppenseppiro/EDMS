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

use App\Mail\SendRequestEntry;
use Illuminate\Support\Facades\Mail;

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

    //---------- Request Entry ----------//
    Route::get('documentrequest', 'RequestEntriesController@index')->name('documentrequest');
    //Route::put('/documentrequest', 'RequestEntriesController@index')->name('documentrequest');
    Route::post('documentrequest/iso/store', 'RequestEntriesController@store_iso');
    Route::post('documentrequest/legal/store', 'RequestEntriesController@store_legal');
    Route::put('documentrequest/{id}', 'RequestEntriesController@update');
    Route::post('documentrequest/requesthistory/iso/{id}', 'RequestEntriesController@history_iso');
    Route::post('documentrequest/requesthistory/legal/{id}', 'RequestEntriesController@history_legal');
    Route::get('requestentryhistory', 'RequestEntryHistoriesController@index');
    Route::post('requestentryhistory/iso/store', 'RequestEntryHistoriesController@iso_store')->name('requestentryhistory_iso');
    Route::post('requestentryhistory/legal/store', 'RequestEntryHistoriesController@legal_store')->name('requestentryhistory_legal');
    //Route::post('requestentryhistory/upload', 'FileUploadsController@store');
    //Email
    /* Route::get('documentrequest/iso/store/email', function(){
        Mail::to('jcjurolan@premiummegastructures.com')->send(new SendRequestEntry());
        return new SendRequestEntry();
    }); */
    Route::get('documentrequest/email', 'RequestEntriesController@sendRequestEntry');

    Route::get('documentrequest/iso/tracking/{dicr}', 'RequestEntryTrackingController@tracking');


    //---------- Request Copy ----------//
    Route::get('documentcopy', 'RequestCopiesController@index')->name('documentcopy');
    Route::post('documentcopy/iso/store', 'RequestCopiesController@store_iso')->name('documentcopy_iso');
    Route::post('documentcopy/requesthistory/iso/{id}', 'RequestCopiesController@history_iso')->name('documentcopyhistory_iso');
    Route::post('requestcopyhistory/iso/store', 'RequestCopyHistoriesController@iso_store')->name('requestcopyhistory_iso');

    
    //---------- Document Library ----------//
    Route::get('documentlibrary', 'DocumentLibrariesController@index')->name('documentlibrary');
    Route::get('documentlibrary/category/tag/{id}', 'DocumentLibrariesController@dependentCategory');
    Route::post('documentlibrary/store', 'DocumentLibrariesController@store');
    Route::post('documentlibrary/user/access', 'DocumentLibraryAccessesController@store');
    Route::post('documentlibrary/user/access/{id}', 'DocumentLibraryAccessesController@access');
    Route::post('documentlibrary/revision/{id}', 'DocumentLibrariesController@revision');
    
    Route::post('documentrevision/store', 'DocumentRevisionsController@store');
    Route::post('documentrevision/user/access', 'DocumentFileRevisionAccessesController@store');
    Route::post('documentrevision/user/access/{id}', 'DocumentFileRevisionAccessesController@access');
    Route::put('documentrevision/user/access/{id}/edit', 'DocumentFileRevisionAccessesController@edit');
    Route::put('documentrevision/file/{id}/edit', 'DocumentFileRevisionsController@edit');

    //---------- E-Transmittal ----------//
    Route::get('etransmittal', 'EtransmittalsController@index')->name('etransmittal');
    Route::post('etransmittal/store', 'EtransmittalsController@store')->name('etransmittal_store');
    Route::post('etransmittal/edit/{etransmittalID}', 'EtransmittalsController@edit')->name('etransmittal_edit');
    Route::post('etransmittal/history/store', 'EtransmittalsController@history_store')->name('etransmittal_history_store');
    Route::post('etransmittal/history/{etransmittalID}', 'EtransmittalsController@history_view');

    //---------- PDF View ----------//
    Route::get('/pdf/iso/{link}', 'FilesController@documentFile')->name('pdf_iso');
    Route::get('/pdf/iso/requestcopy/{uniquelink}', 'FilesController@requestCopy');
    Route::get('/pdf/isoview/{link}', 'FilesController@viewISO');

    

    Route::post('showRequestEntry', 'RequestEntriesController@show');
});