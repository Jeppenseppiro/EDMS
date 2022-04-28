<?php

namespace App\Http\Controllers;

use App\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileUploadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileUpload = new FileUpload;
        // Validation
        $this->validate($request, [
            'requestEntry_FileUploadUpdate' => 'nullable|max:3999'
        ]);

        //Handle File Upload
        if($request->hasFile('requestEntry_FileUploadUpdate')){
            $fileNameWithExt = $request->file('requestEntry_FileUploadUpdate')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('requestEntry_FileUploadUpdate')->getClientOriginalExtension();
            $fileNameToStore = $filename.'-'.time().'.'.$extension;
            //$path = $request->file('requestEntry_FileUploadUpdate')->storeAs('public/resource/uploads', $fileNameToStore);

            //$fileNameToStore = $request->file('requestEntry_FileUploadUpdate');
        } else {
            $fileNameToStore = "noimage.jpg";
        }

        //Get next auto-increment of Entry History
        $getCurrentEntryHistoryID = DB::select("SHOW TABLE STATUS LIKE 'request_entry_histories'");
        $nextCurrentEntryHistoryID = $getCurrentEntryHistoryID[0]->Auto_increment;

        $fileUpload->request_entry = $request->updateISO_ID;
        $fileUpload->request_entry_history = $nextCurrentEntryHistoryID;
        $fileUpload->file_upload = $fileNameToStore;
        $fileUpload->tag = $request->updateISO_TagID;
        $fileUpload->user = $request->updateISO_UserID;
        //$fileUpload->save();
        //$fileNameToStore = $request->file('requestEntry_FileUploadUpdate');
        //$fileName = $request->requestEntry_FileUploadUpdate;
        return $fileUpload;
        //return $fileNameToStore;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function show(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function edit(FileUpload $fileUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileUpload $fileUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FileUpload  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileUpload $fileUpload)
    {
        //
    }
}
