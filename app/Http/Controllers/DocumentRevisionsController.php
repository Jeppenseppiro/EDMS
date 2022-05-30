<?php

namespace App\Http\Controllers;
use App\DocumentLibrary;
use App\DocumentRevision;
use App\DocumentFileRevision;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class DocumentRevisionsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'documentLibrary_Attachment' => ['required','max:100000'],
            /* 'documentLibrary_Revision' => [
                'required',
                Rule::unique('document_revisions,revision','document_revisions,document_library_id')
            ], */
        ]);
        $oldRevision = DocumentRevision::where('document_library_id', $request->updateDocumentLibrary_ID)->orderBy('id','desc')->first();
        $oldRevision != null ? $revisionData = $oldRevision->revision + 1 : $revisionData = 0;

        $documentRevision = new DocumentRevision;
        $documentRevision->user = auth()->user()->id;
        $documentRevision->document_library_id = $request->updateDocumentLibrary_ID;
        $documentRevision->revision = $revisionData;
        $documentRevision->effective_date = $request->documentLibrary_DateEffective;
        $documentRevision->control_code = $request->documentLibrary_ControlCode;
        $documentRevision->remarks = $request->documentLibrary_Remarks;
        $documentRevision->save();
      
        if($documentRevision->id != null)
        {
            $oldRevision->is_obsolete = 1;
            $oldRevision->save();

            
            $attachmentTypes = $request->documentLibrary_AttachmentType;
            if ($request->hasFile('documentLibrary_Attachment')) {
                foreach ($request->file('documentLibrary_Attachment') as $key => $attachment) {
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
                    $documentFileRevision->document_revision_id = $documentRevision->id;
                    $documentFileRevision->attachment = $fileNameToStore;
                    $documentFileRevision->attachment_mask = $path_basename;
                    $documentFileRevision->type = $attachmentTypes[$key];
                    $documentFileRevision->file_password = $fileRevision_Password;
                    $documentFileRevision->user = auth()->user()->id;
                    $documentFileRevision->save();
                }
            }
        }


        return redirect()->back();
    }

    public function store_revision(Request $request)
    {
        return $request->all();
    }

}
