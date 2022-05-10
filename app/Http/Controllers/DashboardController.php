<?php

namespace App\Http\Controllers;

use App\RequestIsoEntry;
use App\RequestIsoCopy;
use App\DocumentLibrary;
use App\Etransmittal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $requestEntries = RequestIsoEntry::get();
        $requestCopies = RequestIsoCopy::get();
        $documentLibraries = DocumentLibrary::get();
        $eTransmittals = Etransmittal::get();

        /* $requestEntries_Chart = RequestIsoEntry::
                                select(DB::raw("COUNT(*) as count"))
                                ->whereYear('created_at',date('Y'))
                                ->groupBy(DB::raw("MONTH(created_at)"))
                                ->pluck('count');

        $requestEntries_Month = RequestIsoEntry::
                                select(DB::raw("MONTH(created_at) as month"))
                                ->whereYear('created_at',date('Y'))
                                ->groupBy(DB::raw("MONTH(created_at)"))
                                ->pluck('month');

        $requestEntries_Datas = array(0,0,0,0,0,0,0,0,0,0,0,0);

        foreach ($requestEntries_Datas as $index => $requestEntries_Data) {
            $requestEntries_Datas[$requestEntries_Month] = $requestEntries_Chart[$index];
        } */

        //dd($requestEntries_Chart);
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
