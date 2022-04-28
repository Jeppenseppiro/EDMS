<?php

namespace App\Http\Controllers;
use Notification;
use App\RequestIsoEntry;
use App\RequestLegalEntry;
use App\RequestEntryHistory;
use App\RequestEntryStatus;
use App\User;
use App\FileUpload;
use App\Http\Controllers\EmailSendController;
use App\Notifications\SendRequestEntry;
use App\Notifications\SendRequestEntryDocumentControlOfficer;
use App\Notifications\SendRequestEntryBusinessProcessManager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestEntryHistoriesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $requestEntryHistories = RequestEntryHistory::with('requestISOEntry','requestStatus')->get();
        //dd($requestIsoEntryHistories);

        return $requestEntryHistories;
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
    public function iso_store(Request $request)
    {
        $requestEntryHistory = new RequestEntryHistory;
        $requestEntryHistory->request_iso_entry_id = $request->updateISO_ID;
        $requestEntryHistory->tag = $request->updateISO_TagID;
        $requestEntryHistory->status = $request->requestEntry_StatusUpdate;
        $requestEntryHistory->remarks = $request->requestEntry_RemarksUpdate;
        $requestEntryHistory->user = $request->updateISO_UserID;
        $requestEntryHistory->save();
        //return redirect('/documentrequest');
        
        // Validation
        $this->validate($request, [
            'requestEntry_FileUploadUpdate' => 'nullable|max:3999'
        ]);

        //Handle File Upload
        if($request->hasFile('requestEntry_FileUploadUpdate')){
            $fileNameWithExt = $request->file('requestEntry_FileUploadUpdate')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('requestEntry_FileUploadUpdate')->getClientOriginalExtension();
            $fileNameToStore = time().'-'.$filename.'.'.$extension;
            $path = $request->file('requestEntry_FileUploadUpdate')->storeAs('public/resource/uploads/iso', $fileNameToStore);

            //$fileNameToStore = $request->file('requestEntry_FileUploadUpdate');
        } else {
            $extension = $request->file('requestEntry_FileUploadUpdate')->getClientOriginalExtension();
            $fileNameToStore = "noimage.".$extension;
        }

        //Get next auto-increment of Entry History
        $getCurrentEntryHistoryID = RequestEntryHistory::get();
        $nextCurrentEntryHistoryID = $getCurrentEntryHistoryID->count();

        $fileUpload = new FileUpload;
        $fileUpload->request_entry = $request->updateISO_ID;
        $fileUpload->request_entry_history = $nextCurrentEntryHistoryID;
        $fileUpload->file_upload = $fileNameToStore;
        $fileUpload->tag = $request->updateISO_TagID;
        $fileUpload->user = $request->updateISO_UserID;
        $fileUpload->save();

        if (auth()->user()->role == 3){
            $bpm = User::where('role', '=', 4)->first();
            $bpm_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
            $bpm_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
            $requestEntryEmail = [
                'dicr_no' => $bpm_dicr->dicr_no,
                'title' => $bpm_dicr->title,
                'status' => $bpm_status->status,
                'remarks' => $request->requestEntry_RemarksUpdate,
            ];
            Notification::send($bpm, new SendRequestEntry($requestEntryEmail));

        } elseif (auth()->user()->role == 4) {
            $ih_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
            $ih = User::where([
                ['id', '=', $ih_dicr->requestor_name],
            ])->first();
            $ih = User::where([
                ['company', '=', $ih->company],
                ['role', '=', 5],
            ])->first();
            $ih_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
            $requestEntryEmail = [
                'dicr_no' => $ih_dicr->dicr_no,
                'title' => $ih_dicr->title,
                'status' => $ih_status->status,
                'remarks' => $request->requestEntry_RemarksUpdate,
            ];
            Notification::send($ih, new SendRequestEntry($requestEntryEmail));



            $dco_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
            $dco = User::where([
                ['id', '=', $dco_dicr->requestor_name],
            ])->first();
            $dco = User::where([
                ['company', '=', $dco->company],
                ['role', '=', 3],
            ])->first();
            $dco_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
            $requestEntryEmail = [
                'dicr_no' => $dco_dicr->dicr_no,
                'title' => $dco_dicr->title,
                'status' => $dco_status->status,
                'remarks' => $request->requestEntry_RemarksUpdate,
            ];
            Notification::send($dco, new SendRequestEntry($requestEntryEmail));

        } elseif (auth()->user()->role == 5) {
            $bpm = User::where('role', '=', 4)->first();
            $bpm_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
            $bpm_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
            $requestEntryEmail = [
                'dicr_no' => $bpm_dicr->dicr_no,
                'title' => $bpm_dicr->title,
                'status' => $bpm_status->status,
                'remarks' => $request->requestEntry_RemarksUpdate,
            ];
            Notification::send($bpm, new SendRequestEntry($requestEntryEmail));

        }
        
        $requestor_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
        $requestor = User::where('id', '=', $requestor_dicr->requestor_name)->first();
        $requestor_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
        $requestEntryEmail = [
            'dicr_no' => $requestor_dicr->dicr_no,
            'title' => $requestor_dicr->title,
            'status' => $requestor_status->status,
            'remarks' => $request->requestEntry_RemarksUpdate,
        ];
        Notification::send($requestor, new SendRequestEntry($requestEntryEmail));



        return redirect('documentrequest');
    }

    public function legal_store(Request $request){
        $requestEntryHistory = new RequestEntryHistory;
        $requestEntryHistory->request_iso_entry_id = $request->updateLegal_ID;
        $requestEntryHistory->tag = 2;
        $requestEntryHistory->status = $request->requestLegalEntry_StatusUpdate;
        $requestEntryHistory->remarks = $request->requestLegalEntry_RemarksUpdate;
        $requestEntryHistory->user = auth()->user()->id;
        $requestEntryHistory->save();

        // Validation
        $this->validate($request, [
            'requestLegalEntry_FileUploadUpdate' => 'nullable|max:3999'
        ]);

        //Handle File Upload
        if($request->hasFile('requestLegalEntry_FileUploadUpdate')){
            $fileNameWithExt = $request->file('requestLegalEntry_FileUploadUpdate')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('requestLegalEntry_FileUploadUpdate')->getClientOriginalExtension();
            $fileNameToStore = time().'-'.$filename.'.'.$extension;
            $path = $request->file('requestLegalEntry_FileUploadUpdate')->storeAs('public/resource/uploads/legal', $fileNameToStore);

            //$fileNameToStore = $request->file('requestEntry_FileUploadUpdate');
        } else {
            $extension = $request->file('requestLegalEntry_FileUploadUpdate')->getClientOriginalExtension();
            $fileNameToStore = "noimage.".$extension;
        }

        //Get next auto-increment of Entry History
        $getCurrentEntryHistoryID = RequestEntryHistory::get();
        $nextCurrentEntryHistoryID = $getCurrentEntryHistoryID->count();

        $fileUpload = new FileUpload;
        $fileUpload->request_entry = $request->updateLegal_ID;
        $fileUpload->request_entry_history = $nextCurrentEntryHistoryID;
        $fileUpload->file_upload = $fileNameToStore;
        $fileUpload->tag = 2;
        $fileUpload->user = auth()->user()->id;
        $fileUpload->save();

        return redirect('documentrequest');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestEntryHistory  $requestEntryHistory
     * @return \Illuminate\Http\Response
     */
    public function show(RequestEntryHistory $requestEntryHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestEntryHistory  $requestEntryHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestEntryHistory $requestEntryHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestEntryHistory  $requestEntryHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestEntryHistory $requestEntryHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestEntryHistory  $requestEntryHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestEntryHistory $requestEntryHistory)
    {
        //
    }
}
