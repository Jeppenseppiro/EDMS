<?php

namespace App\Http\Controllers;

use App\RequestIsoEntry;
use Illuminate\Http\Request;

class RequestEntryTrackingController extends Controller
{
    public function tracking($dicr)
    {
        $request_iso_entries = RequestIsoEntry::where('dicr_no', $dicr)->get();
        return view('tracking.request_entry',
            array(
                'request_iso_entries' => $request_iso_entries
            )
        );

        //return $requestIsoEntry;
    }
}
