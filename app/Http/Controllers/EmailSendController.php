<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailSendController extends Controller
{
    public function emailRequestor(){
        $requestor_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
        $requestor = User::where('id', '=', $requestor_dicr->requestor_name)->first();
        $requestor_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
        $requestEntryEmail = [
            'dicr_no' => $requestor_dicr->dicr_no,
            'title' => $requestor_dicr->title,
            'status' => $requestor_status->status,
            'remarks' => $request->requestEntry_RemarksUpdate,
        ];
        Notification::send($requestor, new SendRequestEntry($requestEntryEmail));
    }

    public function emailDCO(){
        $dco_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
        $dco = User::where([
            ['id', '=', $dco_dicr->requestor_name],
        ])->first();
        $dco = User::where([
            ['company', '=', $dco->company],
            ['role', '=', 3],
        ])->first();
        $dco_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
        $requestEntryEmail = [
            'dicr_no' => $dco_dicr->dicr_no,
            'title' => $dco_dicr->title,
            'status' => $dco_status->status,
            'remarks' => $request->requestEntry_RemarksUpdate,
        ];

        Notification::send($dco, new SendRequestEntry($requestEntryEmail));

    }

    public function emailBPM(){
        $bpm = User::where('role', '=', 4)->first();
        $bpm_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
        $bpm_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
        $requestEntryEmail = [
            'dicr_no' => $bpm_dicr->dicr_no,
            'title' => $bpm_dicr->title,
            'status' => $bpm_status->status,
            'remarks' => $request->requestEntry_RemarksUpdate,
        ];
        Notification::send($bpm, new SendRequestEntry($requestEntryEmail));
    }

    public function emailIH(){
        $ih_dicr = RequestIsoEntry::where('id', '=', $request->updateISO_ID)->first();
        $ih = User::where([
            ['id', '=', $ih_dicr->requestor_name],
        ])->first();
        $ih = User::where([
            ['company', '=', $ih->company],
            ['role', '=', 5],
        ])->first();
        $ih_status = RequestEntryStatus::where('id', '=', $request->requestEntry_StatusUpdate)->first();
        $requestEntryEmail = [
            'dicr_no' => $ih_dicr->dicr_no,
            'title' => $ih_dicr->title,
            'status' => $ih_status->status,
            'remarks' => $request->requestEntry_RemarksUpdate,
        ];

        Notification::send($ih, new SendRequestEntry($requestEntryEmail));
    }
}
