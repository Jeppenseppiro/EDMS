<?php

namespace App\Http\Controllers;

use App\RequestIsoEntryHistory;
use Illuminate\Http\Request;

class RequestIsoEntryHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestIsoEntryHistories = RequestIsoEntryHistory::with('requestISOEntry','requestStatus')->get();
        //dd($requestIsoEntryHistories);

        return $requestIsoEntryHistories;
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
        $requestIsoEntryHistory = new RequestIsoEntryHistory;

        $requestIsoEntryHistory->request_iso_entry_id = $request->RequestEntryID;
        $requestIsoEntryHistory->remarks = $request->RemarksUpdate;
        $requestIsoEntryHistory->status = $request->StatusID;
        $requestIsoEntryHistory->user = $request->RequestEntryUser;
        $requestIsoEntryHistory->save();
        return $requestIsoEntryHistory;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestIsoEntryHistory  $requestIsoEntryHistory
     * @return \Illuminate\Http\Response
     */
    public function show(RequestIsoEntryHistory $requestIsoEntryHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestIsoEntryHistory  $requestIsoEntryHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestIsoEntryHistory $requestIsoEntryHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestIsoEntryHistory  $requestIsoEntryHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestIsoEntryHistory $requestIsoEntryHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestIsoEntryHistory  $requestIsoEntryHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestIsoEntryHistory $requestIsoEntryHistory)
    {
        //
    }
}
