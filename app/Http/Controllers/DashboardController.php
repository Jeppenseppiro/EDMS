<?php

namespace App\Http\Controllers;

use App\RequestIsoEntry;
use App\RequestIsoCopy;
use App\DocumentLibrary;
use App\Etransmittal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $role = explode(",",auth()->user()->role);
        $dateToday = date('Y-m-d');

        $requestEntries = RequestIsoEntry::select('id', 'created_at')->get()->groupBy(function($data){
            return Carbon::parse($data->created_at)->format('M');
        });

        $requestEntries_Months = ['January','February','March','April','May','June,','July','August','September','October','November','December'];
        $requestEntries_MonthCount = [];
        foreach ($requestEntries as $month => $values) {
            $requestEntries_Months[] = $month;
            $requestEntries_MonthCount[] = count($values);
        }
        //dd($requestEntries);
        ///////////////////////////////////////////////////////////////

        $requestCopies = RequestIsoCopy::select('id', 'created_at')->get()->groupBy(function($data){
            return Carbon::parse($data->created_at)->format('M');
        });

        $requestCopies_Months = [];
        $requestCopies_MonthCount = [];
        foreach ($requestEntries as $month => $values) {
            $requestCopies_Months[] = $month;
            $requestCopies_MonthCount[] = count($values);
        }

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
                'requestEntries_Months' => $requestEntries_Months,
                'requestEntries_MonthCount' => $requestEntries_MonthCount,
                'requestCopies_Months' => $requestCopies_Months,
                'requestCopies_MonthCount' => $requestCopies_MonthCount,
                'role' => $role,
                'dateToday' => $dateToday,
            )
        );
    }
}
