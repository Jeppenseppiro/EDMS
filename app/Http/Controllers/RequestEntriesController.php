<?php

namespace App\Http\Controllers;

use App\RequestIsoEntry;
use App\RequestEntryHistory;
use App\RequestLegalEntry;
use App\User;
use App\DocumentCategory;
use App\DocumentLibrary;
use App\RequestType;
use App\RequestEntryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RequestEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request_iso_entries = RequestIsoEntry::with('user','requestType','documentType','documentToRevise','requestStatus','requestIsoEntryLatestHistory')->get();
        $request_legal_entries = RequestLegalEntry::with('user','documentType','requestStatus')->get();
        $users = User::get();
        $document_iso_categories = DocumentCategory::where('tag', '=', '1')->get();
        $document_legal_categories = DocumentCategory::where('tag', '=', '2')->get();
        $document_libraries = DocumentLibrary::get();
        $request_types = RequestType::get();
        $request_iso_statuses = RequestEntryStatus::where('tag', '=', '1')->get();
        $request_legal_statuses = RequestEntryStatus::where('tag', '=', '2')->get();
        $request_iso_histories = RequestEntryHistory::get();

        //dd($request_iso_entries);
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
            )
        );
        return $request_iso_entries;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_iso(Request $request)
    {
        $getCurrentEntryID = DB::select("SHOW TABLE STATUS LIKE 'request_iso_entries'");
        $nextCurrentEntryID = $getCurrentEntryID[0]->Auto_increment;

        $requestIsoEntry = new RequestIsoEntry;
        $requestIsoEntry->requestor_name = $request->Requestor;
        $requestIsoEntry->date_request = $request->DateRequest;
        $requestIsoEntry->title = $request->Title;
        $requestIsoEntry->proposed_effective_date = $request->DateEffective;
        $requestIsoEntry->request_type = $request->RequestType;
        $requestIsoEntry->status = $request->Status;
        $requestIsoEntry->document_type = $request->DocumentType;
        $requestIsoEntry->document_to_revise = $request->DocumentRevised;
        $requestIsoEntry->document_purpose_request = $request->DocumentPurposeRequest;

        $requestEntryHistory = new RequestEntryHistory;
        $requestEntryHistory->request_iso_entry_id = $nextCurrentEntryID;
        $requestEntryHistory->remarks = $request->RemarksUpdate;
        $requestEntryHistory->status = $request->Status;
        $requestEntryHistory->user = $request->RequestEntryUser;
        $requestEntryHistory->tag = $request->TagID;

        $requestIsoEntry->save();
        $requestEntryHistory->save();
        return $requestEntryHistory;
    }

    public function store_legal(Request $request)
    {
        $getCurrentEntryID = DB::select("SHOW TABLE STATUS LIKE 'request_legal_entries'");
        $nextCurrentEntryID = $getCurrentEntryID[0]->Auto_increment;

        $requestLegalEntry = new RequestLegalEntry;
        $requestLegalEntry->requestor_name = $request->Requestor;
        $requestLegalEntry->date_request = $request->DateRequest;
        $requestLegalEntry->document_type = $request->DocumentType;
        $requestLegalEntry->attachment = $request->Attachment;
        $requestLegalEntry->status = $request->Status;
        $requestLegalEntry->remarks = $request->Remarks;

        $requestEntryHistory = new RequestEntryHistory;
        $requestEntryHistory->request_iso_entry_id = $nextCurrentEntryID;
        $requestEntryHistory->remarks = $request->RemarksUpdate;
        $requestEntryHistory->status = $request->Status;
        $requestEntryHistory->user = $request->RequestEntryUser;
        $requestEntryHistory->tag = $request->TagID;

        $requestLegalEntry->save();
        $requestEntryHistory->save();
        return $requestLegalEntry;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestIsoEntry  $requestIsoEntry
     * @return \Illuminate\Http\Response
     */
    public function show(RequestIsoEntry $requestIsoEntry)
    {
        $requestIsoEntry = new RequestIsoEntry;
        $requestIsoEntry->ID = $requestIsoEntry->ID;
        return $requestIsoEntry;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestIsoEntry  $requestIsoEntry
     * @return \Illuminate\Http\Response
     */
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
        $requestIsoEntryHistories = RequestEntryHistory::with('user','requestStatus')
                                    ->where([
                                        ['request_iso_entry_id', '=', $id],
                                        ['tag', '=', 1]
                                    ])
                                    ->orderBy('id', 'DESC')->get();
        return $requestIsoEntryHistories;
    }

    public function history_legal(Request $request, $id)
    {
        $requestIsoEntryHistories = RequestEntryHistory::with('user','requestStatus')
                                    ->where([
                                        ['request_iso_entry_id', '=', $id],
                                        ['tag', '=', 2]
                                    ])
                                    ->orderBy('id', 'DESC')->get();
        return $requestIsoEntryHistories;
    }

}
