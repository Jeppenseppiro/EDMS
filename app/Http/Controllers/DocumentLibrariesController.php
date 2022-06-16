<?php

namespace App\Http\Controllers;

use App\DocumentLibrary;
use App\DocumentRevision;
use App\DocumentFileRevision;
use App\DocumentCategory;
use App\FileUpload;
use App\Department;
use App\Company;
use App\Tag;
use App\User;
use App\RequestIsoEntry;
use App\RequestIsoEntryHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class DocumentLibrariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tag)
    {
        if($tag == 'iso'){
            $tagView = 'iso';
            $tagID = '1';
        } elseif($tag == 'legal'){
            $tagView = 'legal';
            $tagID = '2';
        }
        
        $role = explode(",",auth()->user()->role);
        $dateToday = date('Y-m-d');

        $document_libraries = DocumentLibrary::with('user','documentCategory','documentTag','documentDepartment','documentCompany', 'documentRevision.documentFileRevision.documentUserAccess')
                                                ->when(!in_array(1, $role) && !in_array(3, $role), function ($query, $role) {

                                                    $query->when(auth()->user()->company != 5, function ($query){
                                                        $query->where('company', '=', auth()->user()->company);
                                                    });

                                                    $query->whereHas('documentRevision.documentFileRevision.documentUserAccess', function ($query) {
                                                        $query->where('user_access','=',auth()->user()->id);
                                                    });
                                                })
                                                
                                                /* ->when(auth()->user()->company != 5 || !in_array(1, $role), function ($query){
                                                    $query->where('company', '=', auth()->user()->company);
                                                }) */
                                                ->where('tag', '=', $tagID)
                                                ->get();
        
                                    //->join('request_types', 'request_iso_entry_histories.status', '=', 'request_types.id')
                                    //->where('status','=',4)->get();
        $document_categories = DocumentCategory::where([['tag', '=', $tagID],['status', '=', 'Active'],])->get();
        $document_departments = Department::where('status', '=', 'Active')->get();
        $document_companies = Company::get();
        $tags = Tag::get();
        $users = User::with('getUserAccess')
                        /* ->whereHas('getUserAccess', function ($userAccess) {
                            $userAccess->where('user_access','!=',auth()->user()->id);
                        }) */
                        //->where('id', '=', 9)
                        ->get();

        
        //dd($document_libraries);
        return view('documents.document_library',
            array(
                'document_libraries' => $document_libraries,
                'document_categories' => $document_categories,
                'document_departments' => $document_departments,
                'document_companies' => $document_companies,
                'tags' => $tags,
                'users' => $users,
                'dateToday' => $dateToday,
                'tagView' => $tagView,
                'tagID' => $tagID,
                'role' => $role,
            )
        );
        return $document_libraries;
    }

    public function store(Request $request)
    {   
        // Validation
        $attachmentTypes = $request->documentLibrary_AttachmentType;
        // dd($attachmentTypes);

        $this->validate($request, [
            'documentLibrary_Attachment' => ['required', 'max:100000'],
            'documentLibrary_DocumentNumberSeries' => ['required', 'unique:document_libraries,document_number_series'],
        ]);

        $oldRevision = DocumentRevision::where('document_library_id', $request->updateDocumentLibrary_ID)->orderBy('id','desc')->first();
        $oldRevision != null ? $revisionData = $oldRevision->revision + 1 : $revisionData = $request->documentLibrary_Revision;

        //Document Library
        $documentLibrary = new DocumentLibrary;
        $documentLibrary->description = $request->documentLibrary_Description;
        $documentLibrary->category = $request->documentLibrary_Category;
        $documentLibrary->document_number_series = $request->documentLibrary_DocumentNumberSeries;
        $documentLibrary->tag = $request->documentLibrary_Tag;
        $documentLibrary->revision = $revisionData;
        $documentLibrary->control = $request->documentLibrary_Control;
        $documentLibrary->user = auth()->user()->id;
        $documentLibrary->department = $request->documentLibrary_Department;
        $documentLibrary->company = $request->documentLibrary_Company;
        $documentLibrary->save();

        // Document Revision
        $documentRevision = new DocumentRevision;
        $documentRevision->document_library_id = $documentLibrary->id;
        $documentRevision->revision = $revisionData;
        $documentRevision->effective_date = $request->documentLibrary_DateEffective;
        $documentRevision->user = auth()->user()->id;
        $documentRevision->save();

        // Document File Revision
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
       return redirect()->back();
    }

    public function revision(Request $request, $id)
    {
        $role = explode(",",auth()->user()->role);

        $documentRevisions = DocumentRevision::with('documentFileRevision','documentFileRevision.user','documentFileRevision.documentUserAccess','documentFileRevision.manyUserAccess')
                                                ->where([
                                                    ['document_library_id', '=', $id],
                                                ])
                                                ->when(!in_array(1, $role) && !in_array(3, $role), function ($query) {
                                                    $query->whereHas('documentFileRevision.manyUserAccess', function ($query) {
                                                        $query->where('user_access','=',auth()->user()->id);
                                                    });
                                                })
                                                ->orderBy('id', 'desc')
                                                ->get();
        return $documentRevisions;
    }
}