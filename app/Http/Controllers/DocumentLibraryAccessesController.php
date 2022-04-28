<?php

namespace App\Http\Controllers;

use App\DocumentLibraryAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentLibraryAccessesController extends Controller
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

    public function access(Request $request, $id)
    {
        $documentLibraryAccesses = DocumentLibraryAccess::with('user','userAccess')
            ->where([
                ['document_library_id', '=', $id],
            ])
            ->orderBy('id', 'DESC')->get();
        return $documentLibraryAccesses;
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
        $documentLibraryAccess = new DocumentLibraryAccess;
        //$documentLibraryAccess->user_access = $request->documentLibrary_Users;
        foreach ($request->documentLibrary_Users as $key => $value) {
            $documentLibraryAccess = [
                'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
                'user_access' => $request->documentLibrary_Users[$key],
                'document_library_id' => $request->documentLibraryAccess_ID,
                'updated_by' => auth()->user()->id,
                'user' => auth()->user()->id,
            ];
            //$documentLibraryAccess->save();
            DB::table('document_library_accesses')->insert($documentLibraryAccess);
        }

        //$documentLibraryAccess->document_library_id = $request->documentLibraryAccess_ID;
        //$documentLibraryAccess->user = auth()->user()->id;
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DocumentLibraryAccess  $documentLibraryAccess
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentLibraryAccess $documentLibraryAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentLibraryAccess  $documentLibraryAccess
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentLibraryAccess $documentLibraryAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentLibraryAccess  $documentLibraryAccess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentLibraryAccess $documentLibraryAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentLibraryAccess  $documentLibraryAccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentLibraryAccess $documentLibraryAccess)
    {
        //
    }
}
