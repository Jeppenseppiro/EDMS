<?php

namespace App\Http\Controllers;

use App\DocumentLibrary;
use App\DocumentCategory;
use App\Tag;
use App\RequestIsoEntry;
use App\RequestIsoEntryHistory;
use Illuminate\Http\Request;

class DocumentLibrariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $document_libraries = DocumentLibrary::with('user','documentCategory','documentTag','getRequestIsoEntry')->get();
                                    //->join('request_types', 'request_iso_entry_histories.status', '=', 'request_types.id')
                                    //->where('status','=',4)->get();
        $document_categories = DocumentCategory::get();
        $tags = Tag::get();
        //dd($document_libraries);
        return view('documents.document_library',
            array(
                'document_libraries' => $document_libraries,
                'document_categories' => $document_categories,
                'tags' => $tags,
            )
        );
        return $document_libraries;
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
        $documentLibrary = new DocumentLibrary;
        $documentLibrary->description = $request->Description;
        $documentLibrary->category = $request->Category;
        $documentLibrary->document_number_series = $request->DocumentNumberSeries;
        $documentLibrary->tag = $request->Tag;
        $documentLibrary->revision = $request->Revision;
        $documentLibrary->control = $request->Control;

        $documentLibrary->save();
        return $documentLibrary;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DocumentLibrary  $documentLibrary
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentLibrary $documentLibrary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentLibrary  $documentLibrary
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentLibrary $documentLibrary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentLibrary  $documentLibrary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentLibrary $documentLibrary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentLibrary  $documentLibrary
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentLibrary $documentLibrary)
    {
        //
    }
}
