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

        $requestEntries_Total = RequestIsoEntry::get();
        $requestCopies_Total = RequestIsoCopy::get();
        $documentLibraries_Total = DocumentLibrary::get();
        $eTransmittals_Total = Etransmittal::get();

        $requestEntries = RequestIsoEntry::select('id', 'created_at')->get()->groupBy(function($data){
            return Carbon::parse($data->created_at)->format('F');
        });

        $requestCopies = RequestIsoCopy::select('id', 'created_at')->get()->groupBy(function($data){
            return Carbon::parse($data->created_at)->format('F');
        });

        $documentLibraries = DocumentLibrary::select('id', 'created_at')->get()->groupBy(function($data){
            return Carbon::parse($data->created_at)->format('F');
        });

        $eTransmittals = Etransmittal::select('id', 'created_at')->get()->groupBy(function($data){
            return Carbon::parse($data->created_at)->format('F');
        });

        $requestEntries_array =  $requestEntries->toArray();
        $requestCopies_array =  $requestCopies->toArray();
        $documentLibraries_array = $documentLibraries->toArray();
        $eTransmittals_array = $eTransmittals->toArray();
        
        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $finalData = [];

        foreach($months as $key => $month){
            $datarequestEntriesCount = [];
            $countEntries = 0;
            $countCopies = 0;
            $countDocumentLibraries = 0;
            $countEtransmittals = 0;
            
            if(array_key_exists($month,$requestEntries_array)){
              $countEntries = count($requestEntries_array[$month]);
            }
            
            if(array_key_exists($month,$requestCopies_array)){
              $countCopies = count($requestCopies_array[$month]);
            }

            if(array_key_exists($month,$documentLibraries_array)){
              $countDocumentLibraries = count($documentLibraries_array[$month]);
            }

            if(array_key_exists($month,$eTransmittals_array)){
              $countEtransmittals = count($eTransmittals_array[$month]);
            }
            
            $datarequestEntriesCount = [
                'month' => $month,
                'countEntries' => $countEntries,
                'countCopies' => $countCopies,
                'countDocumentLibraries' => $countDocumentLibraries,
                'countEtransmittals' => $countEtransmittals,
            ];
          
            $finalData[$key] = $datarequestEntriesCount;
        }
        // dd($finalData);
        
        return view('dashboard',
            array(
                'requestEntries_Total' => $requestEntries_Total,
                'requestCopies_Total' => $requestCopies_Total,
                'documentLibraries_Total' => $documentLibraries_Total,
                'eTransmittals_Total' => $eTransmittals_Total,
                'requestEntries' => $requestEntries,
                'requestCopies' => $requestCopies,
                'documentLibraries' => $documentLibraries,
                'eTransmittals' => $eTransmittals,
                'months' => $months,
                'finalData' => $finalData,
            )
        );
    }
}