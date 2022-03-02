<?php

namespace App\Http\Controllers;

use App\RequestIsoEntry;
use App\RequestIsoEntryHistory;
use App\User;
use App\DocumentCategory;
use App\DocumentLibrary;
use App\RequestType;
use App\RequestEntryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RequestIsoEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request_entries = RequestIsoEntry::with('user','requestType','documentType','documentToRevise','requestStatus','requestIsoEntryLatestHistory')->get();
        $users = User::get();
        $document_categories = DocumentCategory::get();
        $document_libraries = DocumentLibrary::get();
        $request_types = RequestType::get();
        $request_statuses = RequestEntryStatus::get();
        $request_iso_histories = RequestIsoEntryHistory::get();

        //dd($request_entries);
        return view('documents.request_entry',
            array(
                'request_entries' => $request_entries,
                'users' => $users,
                'document_categories' => $document_categories,
                'document_libraries' => $document_libraries,
                'request_types' => $request_types,
                'request_statuses' => $request_statuses,
                'request_iso_histories' => $request_iso_histories,
            )
        );
        return $request_entries;
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

        $requestIsoEntryHistory = new RequestIsoEntryHistory;
        $requestIsoEntryHistory->request_iso_entry_id = $nextCurrentEntryID;
        $requestIsoEntryHistory->remarks = "Created new request ISO entry";
        $requestIsoEntryHistory->status = $request->Status;

        $requestIsoEntry->save();
        $requestIsoEntryHistory->save();
        return $requestIsoEntryHistory;
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestIsoEntry  $requestIsoEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestIsoEntry $requestIsoEntry)
    {
        //
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

    public function history(Request $request, $id)
    {
        $requestIsoEntryHistories = RequestIsoEntryHistory::with('user','requestStatus')
                                    ->where('request_iso_entry_id', '=', $id)
                                    ->orderBy('id', 'DESC')->get();
        return $requestIsoEntryHistories;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestIsoEntry  $requestIsoEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestIsoEntry $requestIsoEntry)
    {
        //
    }
}
