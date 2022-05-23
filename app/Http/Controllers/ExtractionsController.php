<?php

namespace App\Http\Controllers;

use App\User;
use App\DocumentLibrary;
use Dompdf;
use Dompdf\Dompdf as DompdfDompdf;
use Illuminate\Http\Request;

class ExtractionsController extends Controller
{
    //
    public function library_revision($document_library_id)
    {
        $role = explode(",",auth()->user()->role);

        if(in_array(1, $role) || in_array(3, $role)){
            $document_libraries = DocumentLibrary::with('documentCategory','documentMultipleRevision.documentFileRevision'/* .documentFileRevision.documentUserAccess' */)
                                
                                    ->where('id', '=', $document_library_id)
                                    ->get();
            // dd($document_libraries);

            $users = User::get();
            // return view('extractions.history_library_revisions');
            $viewhtml = view('extractions.history_library_revisions', 
                array(
                    'users' => $users,
                    'document_libraries' => $document_libraries,
                )
            )->render();

            $dompdf = new DompdfDompdf();
            $dompdf->loadHtml($viewhtml);

            // (Optional) Setup the paper size and orientation
            // $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            //$dompdf->stream();
            $dompdf->stream('file.pdf', array('Attachment' => 0));
        }
    }
}
