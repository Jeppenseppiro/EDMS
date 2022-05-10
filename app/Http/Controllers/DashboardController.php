<?php

namespace App\Http\Controllers;

use App\RequestIsoEntry;
use App\RequestIsoCopy;
use App\DocumentLibrary;
use App\Etransmittal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $requestEntries = RequestIsoEntry::get();
        $requestCopies= RequestIsoCopy::get();
        $documentLibraries = DocumentLibrary::get();
        $eTransmittals = Etransmittal::get();

        $requestEntries_Chart = RequestIsoEntry::
                                get();

        //dd($requestEntries);
        return view('dashboard',
            array(
                'requestEntries' => $requestEntries,
                'requestCopies' => $requestCopies,
                'documentLibraries' => $documentLibraries,
                'eTransmittals' => $eTransmittals,
            )
        );
    }
}
