<?php

namespace App\Http\Controllers;

use App\DocumentFileRevision;
use Illuminate\Http\Request;

class DocumentFileRevisionsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DocumentFileRevision  $documentFileRevision
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentFileRevision $documentFileRevision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentFileRevision  $documentFileRevision
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $edit_documentFileRevision = DocumentFileRevision::find($id);
        if($request->documentFileRevision_IsStamped != null){
            $edit_documentFileRevision->is_stamped = $request->documentFileRevision_IsStamped;
        } if($request->documentFileRevision_IsDiscussed != null){
            $edit_documentFileRevision->is_discussed = $request->documentFileRevision_IsDiscussed;
        }

        $edit_documentFileRevision->save();
        return $edit_documentFileRevision;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentFileRevision  $documentFileRevision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentFileRevision $documentFileRevision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentFileRevision  $documentFileRevision
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentFileRevision $documentFileRevision)
    {
        //
    }
}
