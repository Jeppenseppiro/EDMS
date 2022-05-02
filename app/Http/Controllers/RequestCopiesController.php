<?php

namespace App\Http\Controllers;

use App\RequestIsoCopy;
use App\RequestCopyHistory;
use App\User;
use App\DocumentLibrary;
use App\RequestIsoCopyStatus;
use App\RequestIsoCopyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RequestCopiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = explode(",",auth()->user()->role);
        $dateToday = date('Y-m-d');
        $request_iso_copies = RequestIsoCopy::with('requestor','documentRequested.documentRevision.documentFileRevision','requestCopyType','requestIsoCopyLatestHistory')
                                            ->whereHas('requestor', function ($requestorImmediateHead) {
                                                $requestorImmediateHead->where('department', '=', auth()->user()->department);
                                            })
                                            ->orderBy('id', 'DESC')
                                            ->get();
        $users = User::where('department', '=', auth()->user()->department)->get();
        $document_libraries = DocumentLibrary::where('company', '=', auth()->user()->company)->get();
        $request_iso_copy_statuses = RequestIsoCopyStatus::where("is_active", '=', 'Active')->get();
        $request_iso_copy_types = RequestIsoCopyType::get();

        $emailrequestor = User::where('request_copy_histories.request_copy_id', '=', 1)
                                ->join('request_copy_histories', 'request_copy_histories.user', '=', 'users.id')
                                ->first();

        //dd($request_iso_copies);
        return view('documents.request_copy',
            array(
                'request_iso_copies' => $request_iso_copies,
                'users' => $users,
                'document_libraries' => $document_libraries,
                'request_iso_copy_statuses' => $request_iso_copy_statuses,
                'request_iso_copy_types' => $request_iso_copy_types,
                'role' => $role,
                'dateToday' => $dateToday,
            )
        );
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
    public function store_iso(Request $request)
    {
        /* $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters  
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $requestCopy_Code = '';
        foreach (array_rand($seed, 6) as $k) $requestCopy_Code .= $seed[$k]; */
        $getLastDICR = DB::table('request_iso_entries')->count();

        $requestIsoCopy = new RequestIsoCopy;
        $requestIsoCopy->code = date("Y")."-".sprintf('%06d', $getLastDICR + 1);
        $requestIsoCopy->user = $request->requestISOCopy_Requestor;
        $requestIsoCopy->date_request = $request->requestISOCopy_DateRequest;
        $requestIsoCopy->document_library_id = $request->requestISOCopy_FileRequest;
        $requestIsoCopy->copy_type = $request->requestISOCopy_FileRequestType;
        $requestIsoCopy->save();

        $requestCopyHistory = new RequestCopyHistory;
        $requestCopyHistory->request_copy_id = $requestIsoCopy->id;
        $requestCopyHistory->remarks = "New request copy";
        $requestCopyHistory->status = 1;
        $requestCopyHistory->tag = 1;
        $requestCopyHistory->user = $request->requestISOCopy_Requestor;
        $requestCopyHistory->save();

        return redirect('documentcopy');
    }

    public function history_iso(Request $request, $id)
    {
        $requestIsoCopyHistories = RequestCopyHistory::with('user','requestStatus')
                                    ->where([
                                        ['request_copy_id', '=', $id],
                                        ['tag', '=', 1]
                                    ])
                                    ->orderBy('id', 'DESC')->get();
        return $requestIsoCopyHistories;
    }
}
