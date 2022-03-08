<?php

namespace App\Http\Controllers;

use App\RequestEntryHistory;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $requestEntryHistory = new RequestEntryHistory;

        $requestEntryHistory->request_iso_entry_id = $request->RequestEntryID;
        $requestEntryHistory->remarks = $request->RemarksUpdate;
        $requestEntryHistory->status = $request->StatusID;
        $requestEntryHistory->user = $request->RequestEntryUser;
        $requestEntryHistory->tag = $request->TagID;
        $requestEntryHistory->save();
        return $requestEntryHistory;
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
