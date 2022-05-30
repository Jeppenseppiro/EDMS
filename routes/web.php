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
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/home',  'RequestEntriesController@get_data');
    Route::get('/api/documentrequest', 'RequestEntriesController@get_data');

    /* Route::get('/document', 'PagesController@documentRequest')->name('document'); */

    //Users
    Route::resource('users', 'UsersController');
    Route::post('add-user', 'UsersController@store');

    //---------- Request Entry ----------//
    //Route::get('documentrequest', 'RequestEntriesController@index')->name('documentrequest');
    Route::get('documentrequest/{tag}', 'RequestEntriesController@index');
    //Route::put('/documentrequest', 'RequestEntriesController@index')->name('documentrequest');
    Route::post('documentrequest/documentrequest/iso/store', 'RequestEntriesController@store_iso');
    Route::post('documentrequest/documentrequest/legal/store', 'RequestEntriesController@store_legal');
    Route::put('documentrequest/documentrequest/{id}', 'RequestEntriesController@update');
    Route::post('documentrequest/documentrequest/requesthistory/iso/{id}', 'RequestEntriesController@history_iso');
    Route::post('documentrequest/documentrequest/requesthistory/legal/{id}', 'RequestEntriesController@history_legal');
    Route::post('documentrequest/documentrequest/documenttype/iso/{id}', 'RequestEntriesController@documentInformationType');

    Route::get('documentrequest/requestentryhistory', 'RequestEntryHistoriesController@index');
    Route::post('documentrequest/requestentryhistory/iso/store', 'RequestEntryHistoriesController@iso_store')->name('requestentryhistory_iso');
    Route::post('documentrequest/requestentryhistory/legal/store', 'RequestEntryHistoriesController@legal_store')->name('requestentryhistory_legal');
    //Route::post('requestentryhistory/upload', 'FileUploadsController@store');
    //Email
    /* Route::get('documentrequest/iso/store/email', function(){
        Mail::to('jcjurolan@premiummegastructures.com')->send(new SendRequestEntry());
        return new SendRequestEntry();
    }); */

    Route::get('documentrequest/iso/tracking/{dicr}', 'RequestEntryTrackingController@tracking');


    //---------- Request Copy ----------//
    Route::get('documentcopy/{tag}', 'RequestCopiesController@index');
    Route::post('documentcopy/documentcopy/iso/store', 'RequestCopiesController@store_iso')->name('documentcopy_iso');
    Route::post('documentcopy/documentcopy/requesthistory/iso/{id}', 'RequestCopiesController@history_iso')->name('documentcopyhistory_iso');
    Route::post('documentcopy/documentcopy/requestconfig/iso/{id}', 'RequestCopiesController@config_iso')->name('documentcopyconfig_iso');
    Route::put('documentcopy/documentcopy/requestconfig/iso/{id}/edit', 'RequestCopiesController@edit_iso')->name('documentcopyedit_iso');
    Route::post('documentcopy/requestcopyhistory/iso/store', 'RequestCopyHistoriesController@iso_store')->name('requestcopyhistory_iso');

    
    //---------- Document Library ----------//
    //Route::get('documentlibrary', 'DocumentLibrariesController@index')->name('documentlibrary');
    Route::get('documentlibrary/{tag}', 'DocumentLibrariesController@index');

    Route::post('documentlibrary/documentlibrary/store', 'DocumentLibrariesController@store')->name('documentlibrary.store');
    Route::post('documentlibrary/documentlibrary/user/access', 'DocumentLibraryAccessesController@store');
    Route::post('documentlibrary/documentlibrary/user/access/{id}', 'DocumentLibraryAccessesController@access');
    Route::post('documentlibrary/documentlibrary/revision/{id}', 'DocumentLibrariesController@revision');
    
    Route::post('documentlibrary/documentrevision/store', 'DocumentRevisionsController@store');
    Route::post('documentlibrary/documentrevision/user/access', 'DocumentFileRevisionAccessesController@store');
    Route::post('documentlibrary/documentrevision/user/access/{id}', 'DocumentFileRevisionAccessesController@access');
    Route::put('documentlibrary/documentrevision/user/access/{id}/edit', 'DocumentFileRevisionAccessesController@edit');
    Route::post('documentlibrary/documentrevision/file/store', 'DocumentFileRevisionsController@store');
    Route::put('documentlibrary/documentrevision/file/{id}/edit', 'DocumentFileRevisionsController@edit');

    //---------- E-Transmittal ----------//
    Route::get('etransmittal', 'EtransmittalsController@index')->name('etransmittal');
    Route::post('etransmittal/store', 'EtransmittalsController@store')->name('etransmittal_store');
    Route::post('etransmittal/edit/{etransmittalID}', 'EtransmittalsController@edit')->name('etransmittal_edit');
    Route::post('etransmittal/history/store', 'EtransmittalsController@history_store')->name('etransmittal_history_store');
    Route::post('etransmittal/history/{etransmittalID}', 'EtransmittalsController@history_view');

    //---------- Permitting and Licenses ----------//
    Route::get('permittingandlicenses', 'PermitLicensesController@index')->name('permittingandlicenses');
    Route::post('permittingandlicenses/store', 'PermitLicensesController@store')->name('permittingandlicenses.store');

    //---------- PDF View ----------//
    Route::get('/file/{link}', 'FilesController@documentFile')->name('pdf_iso');
    // Route::get('/file/requestentry/{link}', 'FilesController@requestentryFile')->name('requestentry.file');
    Route::get('/file/etransmittal/{link}', 'FilesController@etransmittalFile')->name('etransmittal.file');
    Route::get('/file/permittinglicenses/{link}', 'FilesController@permittingLicenses')->name('permittingandlicenses.file');
    Route::get('/file/{attachment}/{uniquelink}', 'FilesController@requestCopy');
    Route::get('/pdf/isoview/{link}', 'FilesController@viewISO');

    //---------- PDF Export ----------//
    Route::get('/extraction/library/{document_library_id}', 'ExtractionsController@library_revision')->name('extraction.documentlibrary');
});