<?php

namespace App\Http\Controllers;

use App\DocumentFileRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class DocumentFileRevisionsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'documentLibrary_AttachmentRevision' => ['required','max:100000'],
            'documentLibrary_AttachmentRevisionType' => ['required']
        ]);

        $attachmentTypes = $request->documentLibrary_AttachmentRevisionType;
        if ($request->hasFile('documentLibrary_AttachmentRevision')) {
            foreach ($request->file('documentLibrary_AttachmentRevision') as $key => $attachment) {
                $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters  
                shuffle($seed); // probably optional since array_is randomized; this may be redundant
                $fileRevision_Password = '';
                foreach (array_rand($seed, 6) as $k) $fileRevision_Password .= $seed[$k];

                $fileNameWithExt = $attachment->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $attachment->getClientOriginalExtension();
                $fileNameToStore = $filename . '.' . $extension;

                if ($request->documentLibrary_Tag == 1) {$tag = 'iso';} elseif ($request->documentLibrary_Tag == 2) {$tag = 'legal';} else { $tag = 'others';}

                $path = Storage::putFile('public/document/' . $extension . '/' . $tag, $attachment);
                $path_basename = basename($path);

                
                // DocumentFileRevision::where('document_revision_id', $documentRevision->id)->update(['is_obsolete' => 1]);

                $documentFileRevision = new DocumentFileRevision;
                $documentFileRevision->document_revision_id = $request->documentLibrary_RevisionID;
                $documentFileRevision->attachment = $fileNameToStore;
                $documentFileRevision->attachment_mask = $path_basename;
                $documentFileRevision->type = $attachmentTypes[$key];
                $documentFileRevision->file_password = $fileRevision_Password;
                $documentFileRevision->user = auth()->user()->id;
                $documentFileRevision->save();
            }
        }

        return redirect()->back();
    }

    public function edit(Request $request, $id)
    {
        $edit_documentFileRevision = DocumentFileRevision::find($id);
        if($request->documentFileRevision_IsStamped != null){
            $edit_documentFileRevision->is_stamped = $request->documentFileRevision_IsStamped;
        } if($request->documentFileRevision_IsDiscussed != null){
            $edit_documentFileRevision->is_discussed = $request->documentFileRevision_IsDiscussed;
        } if($request->documentFileRevision_IsDeleted != null){
            $edit_documentFileRevision->is_deleted = $request->documentFileRevision_IsDeleted;
        }

        $edit_documentFileRevision->save();
        return $edit_documentFileRevision;
    }

}
