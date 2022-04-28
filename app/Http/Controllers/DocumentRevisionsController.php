<?php

namespace App\Http\Controllers;

use App\DocumentRevision;
use App\DocumentFileRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentRevisionsController extends Controller
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
        $this->validate($request, [
            'documentLibrary_Attachment' => 'nullable|max:20000'
        ]);
        
        $documentRevision = new DocumentRevision;
        $documentRevision->user = auth()->user()->id;
        $documentRevision->document_library_id = $request->updateDocumentLibrary_ID;
        $documentRevision->revision = $request->documentLibrary_Revision;
        $documentRevision->effective_date = $request->documentLibrary_DateEffective;
        $documentRevision->save();

        $attachmentTypes = $request->documentLibrary_AttachmentType;
        foreach ($request->file('documentLibrary_Attachment') as $key => $attachment) {
            $fileNameWithExt = $attachment->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $attachment->getClientOriginalExtension();
            $fileNameToStore = $filename . '.' . $extension;

            if ($request->documentLibrary_Tag == 1) {$tag = 'iso';} elseif ($request->documentLibrary_Tag == 2) {$tag = 'legal';} else { $tag = 'others';}

            $path = Storage::putFile('public/document/' . $extension . '/' . $tag, $attachment);
            $path_basename = basename($path);

            $documentFileRevision = new DocumentFileRevision;
            $documentFileRevision->document_revision_id = $documentRevision->id;
            $documentFileRevision->attachment = $fileNameToStore;
            $documentFileRevision->attachment_mask = $path_basename;
            $documentFileRevision->type = $attachmentTypes[$key];
            $documentFileRevision->user = auth()->user()->id;
            $documentFileRevision->save();
        }

        return redirect()->back();
    }

    public function store_revision(Request $request)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DocumentRevision  $documentRevision
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentRevision $documentRevision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentRevision  $documentRevision
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentRevision $documentRevision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentRevision  $documentRevision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentRevision $documentRevision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentRevision  $documentRevision
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentRevision $documentRevision)
    {
        //
    }
}
