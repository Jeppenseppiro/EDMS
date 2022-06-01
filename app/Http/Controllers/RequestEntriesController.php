<?php

namespace App\Http\Controllers;

use App\RequestIsoEntry;
use App\RequestEntryHistory;
use App\RequestLegalEntry;
use App\FileUpload;
use App\User;
use App\DocumentCategory;
use App\DocumentLibrary;
use Notification;
use App\Notifications\SendRequestEntry;
//use App\Notifications\SendRequestEntryDocumentControlOfficer;
use App\RequestType;
use App\RequestEntryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class RequestEntriesController extends Controller
{
    public function index($tag)
    {
        if($tag == 'iso'){
            $tagView = 'iso';
            $tagID = '1';
        } elseif($tag == 'legal'){
            $tagView = 'legal';
            $tagID = '2';
        }
        $role = explode(",",auth()->user()->role);
        $dateToday = date('Y-m-d');


        $request_iso_entries = RequestIsoEntry::with('user','requestType','documentType','documentToRevise','requestStatus','requestIsoEntryLatestHistory')
                                                ->when(!in_array(1, $role) && !in_array(3, $role), function ($query) {
                                                    $query->where('requestor_name','=',auth()->user()->id);
                                                })
                                                ->get();
        $request_legal_entries = RequestLegalEntry::with('user','documentType','requestStatus')
                                                    ->when(!in_array(1, $role) && !in_array(3, $role), function ($query) {
                                                        $query->where('requestor_name','=',auth()->user()->id);
                                                    })
                                                    ->get();


        $users = User::get();
        $document_iso_categories = DocumentCategory::where([
                                                            ['tag', '!=', '2'],
                                                            ['status', '=', 'Active']
                                                    ])->get();
        $document_legal_categories = DocumentCategory::where([
                                                            ['tag', '!=', '1'],
                                                            ['status', '=', 'Active']
                                                    ])->get();
        $document_libraries = DocumentLibrary::where('tag', '=', 1)->get();
        $request_types = RequestType::where('status', '=', 'Active')->get();
        $request_iso_statuses = RequestEntryStatus::where([['tag', '=', '1'], ['id', '!=', '1']])->get();
        $request_legal_statuses = RequestEntryStatus::where([['tag', '=', '2'], ['id', '!=', '7']])->get();
        $request_iso_histories = RequestEntryHistory::get();

        //dd($approver);
        return view('documents.request_entry',
            array(
                'request_iso_entries' => $request_iso_entries,
                'request_legal_entries' => $request_legal_entries,
                'users' => $users,
                'document_iso_categories' => $document_iso_categories,
                'document_legal_categories' => $document_legal_categories,
                'document_libraries' => $document_libraries,
                'request_types' => $request_types,
                'request_iso_statuses' => $request_iso_statuses,
                'request_legal_statuses' => $request_legal_statuses,
                'request_iso_histories' => $request_iso_histories,
                'dateToday' => $dateToday,
                'tagView' => $tagView,
                'role' => $role,
            )
        );
        
        //return $request_iso_entries;
    }


    public function store_iso(Request $request)
    {
        // Validation
        $this->validate($request, [
            'requestEntry_Attachment' => 'nullable|max:100000'
        ]);

        

        //$getCurrentEntryID = DB::select("SHOW TABLE STATUS LIKE 'request_iso_entries'");
        //$nextCurrentEntryID = $getCurrentEntryID[0]->Auto_increment;
        //[year]-[series number]
        $getLastDICR = DB::table('request_iso_entries')->count();

        $requestIsoEntry = new RequestIsoEntry;
        $requestIsoEntry->dicr_no = date("Y")."-".sprintf('%06d', $getLastDICR + 1);
        $requestIsoEntry->requestor_name = $request->requestEntry_Requestor;
        $requestIsoEntry->date_request = $request->requestEntry_DateRequest;
        $requestIsoEntry->title = $request->requestEntry_Title;
        $requestIsoEntry->proposed_effective_date = $request->requestEntry_DateEffective;
        $requestIsoEntry->request_type = $request->requestEntry_RequestType;
        $requestIsoEntry->status = 1;
        $requestIsoEntry->document_type = $request->requestEntry_DocumentType;
        $requestIsoEntry->document_to_revise = $request->requestEntry_DocumentRevised;
        $requestIsoEntry->document_purpose_request = $request->requestEntry_DocumentPurposeRequest;
        $requestIsoEntry->save();

        $requestEntryHistory = new RequestEntryHistory;
        $requestEntryHistory->request_iso_entry_id = $requestIsoEntry->id;
        $requestEntryHistory->remarks = "Created new request entry";
        $requestEntryHistory->status = 1;
        $requestEntryHistory->user = $request->requestEntry_Requestor;
        $requestEntryHistory->tag = 1;
        $requestEntryHistory->save();

        //Handle File Upload
        if($request->hasFile('requestEntry_Attachment')){
            $fileNameWithExt = $request->file('requestEntry_Attachment')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('requestEntry_Attachment')->getClientOriginalExtension();
            $fileNameToStore = $filename.'.'.$extension;

            $path = Storage::putFile('public/requestentry/' . $extension . '/iso/', $request->file('requestEntry_Attachment'));
            $path_basename = basename($path);

            $fileUpload = new FileUpload;
            $fileUpload->request_entry = $requestIsoEntry->id;
            $fileUpload->request_entry_history = $requestEntryHistory->id;
            $fileUpload->file_upload = $fileNameToStore;
            $fileUpload->file_mask = $path_basename;
            $fileUpload->tag = 1;
            $fileUpload->user = $request->requestor_name;
            $fileUpload->save();
        }

        $email_requestIsoEntry = RequestIsoEntry::with('requestType')->where('id', '=', $requestIsoEntry->id)->first();

        $requestor = User::where('id', '=', auth()->user()->id)->first();
        $requestor_DCO = User::where([['company', '=', auth()->user()->company], ['role', '=', 3]])->first();

        $requestEntryEmail = [
            'tag' =>  "Document Management",
            'dicr_no' =>  date_format($requestIsoEntry->created_at,"Y")."-".sprintf('%06d', $requestIsoEntry->id),
            'title' => $request->requestEntry_Title,
            'type' => $email_requestIsoEntry->requestType->description,
            'status' => "New",
            'remarks' => "Created new request entry",
        ];
        Notification::send($requestor, new SendRequestEntry($requestEntryEmail));
        Notification::send($requestor_DCO, new SendRequestEntry($requestEntryEmail));

        return redirect()->back();
    }

    public function store_legal(Request $request)
    {
        // Validation
        $this->validate($request, [
            'requestLegalEntry_Attachment' => 'nullable|max:100000'
        ]);


        $requestLegalEntry = new RequestLegalEntry;
        $requestLegalEntry->requestor_name = $request->requestLegalEntry_Requestor;
        $requestLegalEntry->date_request = $request->requestLegalEntry_DateRequest;
        $requestLegalEntry->document_type = $request->requestLegalEntry_DocumentType;
        //$requestLegalEntry->attachment = $fileNameToStore;
        $requestLegalEntry->status = 1;
        $requestLegalEntry->remarks = $request->requestLegalEntry_Remarks;
        $requestLegalEntry->save();

        $requestEntryHistory = new RequestEntryHistory;
        $requestEntryHistory->request_iso_entry_id = $requestLegalEntry->id;
        $requestEntryHistory->remarks = "Created new request entry";
        $requestEntryHistory->status = 1;
        $requestEntryHistory->user = $request->requestLegalEntry_User;
        $requestEntryHistory->tag = 2;
        $requestEntryHistory->save();

        //Handle File Upload
        if($request->hasFile('requestLegalEntry_Attachment')){
            $fileNameWithExt = $request->file('requestLegalEntry_Attachment')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('requestLegalEntry_Attachment')->getClientOriginalExtension();
            $fileNameToStore = $filename.'.'.$extension;

            $path = Storage::putFile('public/requestentry/' . $extension . '/legal/', $request->file('requestLegalEntry_Attachment'));
            $path_basename = basename($path);

            $fileUpload = new FileUpload;
            $fileUpload->request_entry = $requestLegalEntry->id;
            $fileUpload->request_entry_history = $requestEntryHistory->id;
            $fileUpload->file_upload = $fileNameToStore;
            $fileUpload->file_mask = $path_basename;
            $fileUpload->tag = 2;
            $fileUpload->user = $request->requestor_name;
            $fileUpload->save();
        }

        $requestor = User::where('id', '=', auth()->user()->id)->first();
        $requestor_DCO = User::where([['company', '=', auth()->user()->company], ['role', '=', 3]])->first();
        $requestEntryEmail = [
            'tag' =>  "Legal",
            'dicr_no' =>  date_format($requestLegalEntry->created_at,"Y")."-".sprintf('%06d', $requestLegalEntry->id),
            'title' => $request->requestEntry_Title,
            'type' => "N/A",
            'status' => "New",
            'remarks' => "Created new request entry",
        ];
        Notification::send($requestor, new SendRequestEntry($requestEntryEmail));
        Notification::send($requestor_DCO, new SendRequestEntry($requestEntryEmail));
        
        return redirect()->back();
        //return $fileUpload;
    }
    
    public function update(Request $request, $id)
    {
        $requestIsoEntry = RequestIsoEntry::find($id);
        $requestIsoEntry->requestor_name = $request->Requestor;
        $requestIsoEntry->date_request = $request->DateRequest;
        $requestIsoEntry->title = $request->Title;
        $requestIsoEntry->proposed_effective_date = $request->DateEffective;
        $requestIsoEntry->request_type = $request->RequestType;
        $requestIsoEntry->status = $request->Status;
        $requestIsoEntry->document_type = $request->DocumentType;
        $requestIsoEntry->document_to_revise = $request->DocumentRevised;
        $requestIsoEntry->document_purpose_request = $request->DocumentPurposeRequest;
        $requestIsoEntry->save();
        return $requestIsoEntry;
    }

    public function history_iso(Request $request, $id)
    {
        $requestIsoEntryHistories = RequestEntryHistory::with('user','requestStatus','requestFile')
                                    ->where([
                                        ['request_iso_entry_id', '=', $id],
                                        ['tag', '=', 1]
                                    ])
                                    ->orderBy('id', 'DESC')->get();
        return $requestIsoEntryHistories;
    }

    public function history_legal(Request $request, $id)
    {
        $requestIsoEntryHistories = RequestEntryHistory::with('user','requestStatus','requestFile')
                                    ->where([
                                        ['request_iso_entry_id', '=', $id],
                                        ['tag', '=', 2]
                                    ])
                                    ->orderBy('id', 'DESC')->get();
        return $requestIsoEntryHistories;
    }

    public function documentInformationType(Request $request, $id)
    {
        $documentInformationType = DocumentLibrary::with('documentCategory')
                                    ->where([
                                        ['id', '=', $id]
                                    ])
                                    ->first();
        return $documentInformationType;
    }
}