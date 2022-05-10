<?php

namespace App\Http\Controllers;

use App\RequestCopyHistory;
use App\RequestIsoCopy;
use App\User;
use Notification;
use App\Notifications\SendRequestCopy;
use Illuminate\Http\Request;

class RequestCopyHistoriesController extends Controller
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
    public function iso_store(Request $request)
    {
        $requestCopyHistory = new RequestCopyHistory;
        $requestCopyHistory->request_copy_id = $request->updateRequestCopy_ID;
        $requestCopyHistory->date_expiration = $request->requestCopy_DateExpiration;
        $requestCopyHistory->request_copy_uniquelink = $request->requestCopy_GenerateLink;
        $requestCopyHistory->remarks = $request->requestCopy_RemarksUpdate;
        $requestCopyHistory->status = $request->requestCopy_StatusUpdate;
        $requestCopyHistory->tag = 1;
        $requestCopyHistory->user = $request->updateRequestCopy_UserID;
        $requestCopyHistory->save();

        //$user = User::where('id', '=', auth()->user()->id)->first();
        if($request->requestCopy_StatusUpdate == 3){
            $emailrequestor = User::where('request_copy_histories.request_copy_id', '=', $request->updateRequestCopy_ID)
                            ->join('request_copy_histories', 'request_copy_histories.user', '=', 'users.id')
                            ->first();
            $requestCopy = [
                'remarks' => $request->requestCopy_RemarksUpdate,
            ];
            Notification::send($emailrequestor, new SendRequestCopy($requestCopy));

        }
        //return $requestCopyHistory;
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestCopyHistory  $requestCopyHistory
     * @return \Illuminate\Http\Response
     */
    public function show(RequestCopyHistory $requestCopyHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestCopyHistory  $requestCopyHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestCopyHistory $requestCopyHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestCopyHistory  $requestCopyHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestCopyHistory $requestCopyHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestCopyHistory  $requestCopyHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestCopyHistory $requestCopyHistory)
    {
        //
    }
}
