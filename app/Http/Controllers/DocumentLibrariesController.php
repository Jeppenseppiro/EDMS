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
                                                    $query->whereHas('documentRevision.documentFileRevision.documentUserAccess', function ($userAccess) {
                                                        $userAccess->where('user_access','=',auth()->user()->id);
                                                    });
                                                })
                                                ->where('tag', '=', $tagID)
                                                ->get();
        
                                    //->join('request_types', 'request_iso_entry_histories.status', '=', 'request_types.id')
                                    //->where('status','=',4)->get();
        $document_categories = DocumentCategory::where([['tag', '=', $tagID],['status', '=', 'Active'],])->get();
        $document_departments = Department::get();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dependentCategory($id)
    {
        $documentLibrary_DependentCategory = DocumentCategory::where([
                                                                        ['tag', '=', $id],
                                                                        ['status', '!=', "Inactive"],
                                                                    ])->get();
        return $documentLibrary_DependentCategory;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /* public function store(){
        $documentRevisions = DocumentRevision::with('user', 'revisionFiles')
                                ->where([
                                    ['document_library_id', '=', 10],
                                ])
                                ->get();
        dd($documentRevisions);
    } */

    public function store(Request $request)
    {   
        //dd($request->all());

        // Validation
        $attachmentTypes = $request->documentLibrary_AttachmentType;
        // dd($attachmentTypes);

        $this->validate($request, [
            'documentLibrary_Attachment' => ['required', 'max:30000'],
            'documentLibrary_DocumentNumberSeries' => ['required', 'unique:document_libraries,document_number_series'],
        ]);

        //Handle File Upload
        /* if($request->hasFile('documentLibrary_Attachment')){
            $fileNameWithExt = $request->file('documentLibrary_Attachment')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('documentLibrary_Attachment')->getClientOriginalExtension();
            $fileNameToStore = time().'-'.$filename.'.'.$extension;
            
            if ($request->documentLibrary_Tag == 1) { $tag = 'iso'; }
            elseif ($request->documentLibrary_Tag == 2) { $tag = 'legal'; }
            else { $tag = 'others'; }

            $path = Storage::putFile('app/public/document/'.$extension.'/'.$tag, $request->file('documentLibrary_Attachment'));
            $path_basename = basename($path);
            //$path = $request->file('documentLibrary_Attachment')->storeAs(storage_path('app/pdf/iso/'), $fileNameToStore);

            //$fileNameToStore = $request->file('documentLibrary_Attachment');
        } else {
            $extension = $request->file('documentLibrary_Attachment')->getClientOriginalExtension();
            $fileNameToStore = "noimage.".$extension;
        } */

        // $getDocumentLibraryID = DB::select("SHOW TABLE STATUS LIKE 'document_libraries'");
        // $nextDocumentLibraryID = $getDocumentLibraryID[0]->Auto_increment;

        // $getDocumentRevisionID = DB::select("SHOW TABLE STATUS LIKE 'document_revisions'");
        // $nextDocumentRevisionID = $getDocumentRevisionID[0]->Auto_increment;

        $documentLibrary = new DocumentLibrary;
        $documentLibrary->description = $request->documentLibrary_Description;
        $documentLibrary->category = $request->documentLibrary_Category;
        $documentLibrary->document_number_series = $request->documentLibrary_DocumentNumberSeries;
        $documentLibrary->tag = $request->documentLibrary_Tag;
        $documentLibrary->revision = $request->documentLibrary_Revision;
        $documentLibrary->control = $request->documentLibrary_Control;
        $documentLibrary->user = auth()->user()->id;
        $documentLibrary->department = $request->documentLibrary_Department;
        $documentLibrary->company = $request->documentLibrary_Company;
        $documentLibrary->save();


        // Document Revision
        $documentRevision = new DocumentRevision;
        $documentRevision->document_library_id = $documentLibrary->id;
        $documentRevision->revision = $request->documentLibrary_Revision;
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

        $documentRevisions = DocumentRevision::with('documentFileRevision.user','documentFileRevision.documentUserAccess','documentFileRevision.manyUserAccess')
                                                ->where([
                                                    ['document_library_id', '=', $id],
                                                ])
                                                ->orderBy('id', 'desc')
                                                ->when(!in_array(1, $role), function ($q) {
                                                    $q->skip(0)->take(1);
                                                })
                                                ->get();
        
        return $documentRevisions;
    }
}
