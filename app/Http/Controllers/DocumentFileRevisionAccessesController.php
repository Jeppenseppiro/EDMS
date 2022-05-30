<?php

namespace App\Http\Controllers;

use App\DocumentFileRevisionAccess;
use App\DocumentLibrary;
use App\DocumentRevision;
use App\User;
use Notification;
use App\Notifications\SendDocumentUserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentFileRevisionAccessesController extends Controller
{
    public function store(Request $request)
    {
        $documentFileRevisionAccess = new DocumentFileRevisionAccess;
        //$documentLibraryAccess->user_access = $request->documentLibrary_Users;
        foreach ($request->documentFileRevisionAccess_Users as $key => $value) {
            $documentFileRevisionAccess = [
                'created_at' => \Carbon\Carbon::now(), # new \Datetime()
                'updated_at' => \Carbon\Carbon::now(), # new \Datetime()
                'user_access' => $request->documentFileRevisionAccess_Users[$key],
                'document_file_revision_id' => $request->documentFileRevisionAccess_ID,
                'user' => auth()->user()->id,
            ];
            DB::table('document_file_revision_accesses')->insert($documentFileRevisionAccess);

            $documentFileRevisionAccessEmail = DocumentFileRevisionAccess::with('documentFileRevision.documentRevision.documentLibrary', 'userAccess')
                                                ->whereHas('user', function ($userAccess) use($request, $key) {
                                                    $userAccess->where('user_access', '=', $request->documentFileRevisionAccess_Users[$key]);
                                                })
                                                ->orderBy('id', 'desc')
                                                ->first();
            $documentUserAccessEmail = [
                'documentLibrary_AccessUser' => $documentFileRevisionAccessEmail->userAccess->name,
                'documentLibrary_Series' => $documentFileRevisionAccessEmail->documentFileRevision->documentRevision->documentLibrary->document_number_series,
                'documentRevision_Revision' => $documentFileRevisionAccessEmail->documentFileRevision->documentRevision->revision,
                'documentFileRevision_Attachment' => $documentFileRevisionAccessEmail->documentFileRevision->attachment,
            ];
            Notification::send($documentFileRevisionAccessEmail->userAccess, new SendDocumentUserAccess($documentUserAccessEmail));
        }

        //$documentLibraryAccess->document_library_id = $request->documentLibraryAccess_ID;
        //$documentLibraryAccess->user = auth()->user()->id;
        //return $documentFileRevisionAccessEmail;
        return redirect()->back();
    }

    public function access(Request $request, $id)
    {
        $documentFileRevisionAccesses = DocumentFileRevisionAccess::with('user','userAccess')
            ->where([
                ['document_file_revision_id', '=', $id],
            ])
            ->orderBy('id', 'DESC')->get();
        return $documentFileRevisionAccesses;
    }

    public function edit(Request $request, $id)
    {
        $edit_documentFileRevisionAccesses = DocumentFileRevisionAccess::find($id);
        $edit_documentFileRevisionAccesses->updated_by = auth()->user()->id;
        if($request->documentFileRevision_AccessCanView != null){
            $edit_documentFileRevisionAccesses->can_view = $request->documentFileRevision_AccessCanView;
        } if($request->documentFileRevision_AccessCanPrint != null){
            $edit_documentFileRevisionAccesses->can_print = $request->documentFileRevision_AccessCanPrint;
        } if($request->documentFileRevision_AccessCanFill != null){
            $edit_documentFileRevisionAccesses->can_fill = $request->documentFileRevision_AccessCanFill;
        } if($request->documentFileRevision_IsProcessOwner != null){
            $edit_documentFileRevisionAccesses->is_processowner = $request->documentFileRevision_IsProcessOwner;
        } if($request->documentFileRevision_IsAcknowledged != null){
            $edit_documentFileRevisionAccesses->is_acknowledged = $request->documentFileRevision_IsAcknowledged;
        }
        
        $edit_documentFileRevisionAccesses->save();
        return $edit_documentFileRevisionAccesses;
    }
}
