<?php

namespace App\Http\Controllers;

use App\DocumentFileRevision;
use Illuminate\Http\Request;

class DocumentFileRevisionsController extends Controller
{
   
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

}
