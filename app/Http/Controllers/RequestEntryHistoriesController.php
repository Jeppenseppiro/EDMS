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
    
    public function index()
    {
        //
        $requestEntryHistories = RequestEntryHistory::with('requestISOEntry','requestStatus')->get();
        //dd($requestIsoEntryHistories);

        return $requestEntryHistories;
    }


    public function iso_store(Request $request)
    {
        $requestEntryHistory = new RequestEntryHistory;
        $requestEntryHistory->request_iso_entry_id = $request->updateISO_ID;
        $requestEntryHistory->tag = $request->updateISO_TagID;
        $requestEntryHistory->status = $request->requestEntry_StatusUpdate;
        $requestEntryHistory->remarks = $request->requestEntry_RemarksUpdate;
        $requestEntryHistory->user = auth()->user()->id;
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
            $fileUpload = new FileUpload;
            $fileUpload->request_entry = $request->updateISO_ID;
            $fileUpload->request_entry_history = $requestEntryHistory->id;
            $fileUpload->file_upload = $fileNameToStore;
            $fileUpload->tag = $request->updateISO_TagID;
            $fileUpload->user = $request->updateISO_UserID;
            $fileUpload->save();
        }

        //Get next auto-increment of Entry History
        //$getCurrentEntryHistoryID = RequestEntryHistory::get();
        //$nextCurrentEntryHistoryID = $getCurrentEntryHistoryID->count();

        $email_requestIsoEntry = RequestIsoEntry::with('requestType')->where('id', '=', $request->updateISO_ID)->first();

        $requestIsoEntry = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
        $requestEntryStatus = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();

        $requestor = User::where('id', '=', auth()->user()->id)->first();
        $requestor_DCO = User::where([['company', '=', auth()->user()->company], ['role', '=', 3]])->first();

        $requestEntryEmail = [
            'tag' =>  "Document Management",
            'dicr_no' =>  date_format($requestIsoEntry->created_at,"Y")."-".sprintf('%06d', $requestIsoEntry->id),
            'title' => $requestIsoEntry->title,
            'type' => $email_requestIsoEntry->requestType->description,
            'status' => $requestEntryStatus->status,
            'remarks' => $request->requestEntry_RemarksUpdate,
        ];
        Notification::send($requestor, new SendRequestEntry($requestEntryEmail));
        Notification::send($requestor_DCO, new SendRequestEntry($requestEntryEmail));



        return redirect()->back();
    }


    public function legal_store(Request $request){
        // Validation
        $this->validate($request, [
            'requestLegalEntry_FileUploadUpdate' => 'nullable|max:3999'
        ]);

        $requestEntryHistory = new RequestEntryHistory;
        $requestEntryHistory->request_iso_entry_id = $request->updateLegal_ID;
        $requestEntryHistory->tag = 2;
        $requestEntryHistory->status = $request->requestLegalEntry_StatusUpdate;
        $requestEntryHistory->remarks = $request->requestLegalEntry_RemarksUpdate;
        $requestEntryHistory->user = auth()->user()->id;
        $requestEntryHistory->save();

        $requestLegalEntry = RequestLegalEntry::where('id', '=', $request->updateLegal_ID)->first();
        $requestEntryStatus = RequestEntryStatus::where('id', '=', $request->requestLegalEntry_StatusUpdate)->first();

        $requestor = User::where('id', '=', auth()->user()->id)->first();
        $requestor_DCO = User::where([['company', '=', auth()->user()->company], ['role', '=', 3]])->first();

        $requestEntryEmail = [
            'tag' =>  "Legal",
            'dicr_no' =>  date_format($requestLegalEntry->created_at,"Y")."-".sprintf('%06d', $requestLegalEntry->id),
            'title' => $request->requestEntry_Title,
            'type' => "N/A",
            'status' => $requestEntryStatus->status,
            'remarks' => $request->requestLegalEntry_RemarksUpdate,
        ];
        Notification::send($requestor, new SendRequestEntry($requestEntryEmail));
        Notification::send($requestor_DCO, new SendRequestEntry($requestEntryEmail));

        //Handle File Upload
        /* if($request->hasFile('requestLegalEntry_FileUploadUpdate')){
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

        $fileUpload = new FileUpload;
        $fileUpload->request_entry = $request->updateLegal_ID;
        $fileUpload->request_entry_history = $requestEntryHistory->id;
        $fileUpload->file_upload = $fileNameToStore;
        $fileUpload->tag = 2;
        $fileUpload->user = auth()->user()->id;
        $fileUpload->save(); */

        return redirect()->back();
    }
}