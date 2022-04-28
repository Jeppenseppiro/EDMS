<?php

namespace App\Http\Controllers;
use App\DocumentRevision;
use App\DocumentFileRevision;
use App\DocumentLibrary;
use App\RequestIsoCopy;
use App\RequestCopyHistory;
use tecknickom\tcpdf\tcpdf;

//use rafikhaceb\tcpdi\tcpdi;
//use rafikhaceb\tcpdi\Tcpdi;
//use tecnickcom\tcpdf\Tcpdf;
use mikehaertl\pdftk\Pdf;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function documentFile($link)
    {
        
        if(auth()->user()->role == 1){
            $request_copy_iso = DocumentFileRevision::with('documentRevision.documentLibrary')
                                                ->where([
                                                    ['attachment_mask', '=', $link],
                                                ])
                                                ->first();
        } else {
            $request_copy_iso = DocumentFileRevision::with('documentUserAccess','documentRevision.documentLibrary')
                                                ->whereHas('documentUserAccess', function ($userAccess) {
                                                    $userAccess->where('user_access', '=', auth()->user()->id);
                                                })
                                                ->where([
                                                    ['attachment_mask', '=', $link],
                                                ])
                                                ->first();
        }
        
        //dd($request_copy_iso);
        
        if(!empty($request_copy_iso)){
            // Source file and watermark config
            if($request_copy_iso->documentRevision->documentLibrary->tag == 1){ $fileCategory = 'iso'; }
            elseif($request_copy_iso->documentRevision->documentLibrary->tag == 2){ $fileCategory = 'legal'; }
            elseif($request_copy_iso->documentRevision->documentLibrary->tag == 3){ $fileCategory = 'other'; }
            
            $file = storage_path('app/public/document/pdf/'.$fileCategory.'/').$link;
            $tmpFile = storage_path('app/public/tmp/').auth()->user()->id."_".$link;
            if($request_copy_iso->is_stamped == 1){
                $watermarkFile = storage_path('app/controlledcopy_watermark.pdf');
            } else {
                $watermarkFile = storage_path('app/controlledcopy_blank.pdf');
            }
            
            $owner_password = "owner";
            $user_password = "user";
            
            //User Access
            if($request_copy_iso->documentUserAccess != null || auth()->user()->role == 1){
                //dd($request_copy_iso);
                $pdfPassword1 = new Pdf();
                $pdfPassword2 = new Pdf();
                $pdfPassword3 = new Pdf();

                $pdf = new Pdf();

                if(auth()->user()->role != 1){
                    //Allow Printing
                    $request_copy_iso->documentUserAccess->can_print == 1 ? $allow_printing = "Printing" : $allow_printing = null;
                    //Allow Fill-In
                    $request_copy_iso->documentUserAccess->can_fill == 1 ? $allow_fillin = "FillIn" : $allow_fillin = null;
                } else {
                    $allow_printing = null;
                    $allow_fillin = null;
                }
                

                //Allow Fill-In
                auth()->user()->role == 1 ? $allow_allFeatures = "AllFeatures" : $allow_allFeatures = null;
                
                if($pdfPassword1->addFile($file, 'A', 'ihdcpchi...')->saveAs($tmpFile) === true){
                    $pdfPassword_status = true;
                    $pdfPassword_password = "ihdcpchi...";
                } elseif ($pdfPassword2->addFile($file, 'A', 'pchi...')->saveAs($tmpFile) === true) {
                    $pdfPassword_status = true;
                    $pdfPassword_password = "pchi...";
                } elseif ($pdfPassword3->addFile($file, 'A', 'holdings...')->saveAs($tmpFile) === true) {
                    $pdfPassword_status = true;
                    $pdfPassword_password = "holdings...";
                } else {
                    abort(404, 'Forbidden');
                }

                $result = $pdf/*-> {($pdfPassword_status  === true)  ? 'addFile' : 'setProp3'}($file, 'A', $pdfPassword_password) */
                                ->addFile($file, 'A', $pdfPassword_password)
                                ->allow($allow_printing)
                                ->allow($allow_fillin)
                                ->allow($allow_allFeatures)
                                ->setPassword($owner_password)          // Set owner password
                                ->setUserPassword($user_password)      // Set user password
                                ->passwordEncryption(128)   // Set password encryption strength
                                ->multiStamp($watermarkFile)
                                ->saveAs($tmpFile);
                if ($result === false) {
                    $error = $pdf->getError();
                    echo $error;
                }

                return response()->file($tmpFile);
                
            } else {
                abort(403, 'Forbidden');
            }
        } else {
            abort(403, 'Forbidden');
        }
    }

    public function requestCopy($uniquelink)
    {
        if(auth()->user()->role == 1){
            $request_copy = DocumentFileRevision::with('documentRevision.documentLibrary.requestIsoCopy.requestIsoCopyHistory')
                                                ->whereHas('documentRevision.documentLibrary.requestIsoCopy.requestIsoCopyHistory', function ($userAccess) use($uniquelink){
                                                    $userAccess->where('request_copy_uniquelink', '=', $uniquelink);
                                                })
                                                ->first();
        } else {
            $request_copy = DocumentFileRevision::with('documentUserAccess','documentRevision.documentLibrary.requestIsoCopy.requestIsoCopyHistory')
                                                ->whereHas('documentUserAccess', function ($userAccess) {
                                                    $userAccess->where('user_access', '=', auth()->user()->id);
                                                })
                                                ->whereHas('documentRevision.documentLibrary.requestIsoCopy.requestIsoCopyHistory', function ($userLink) use($uniquelink){
                                                    $userLink->where('request_copy_uniquelink', '=', $uniquelink);
                                                })
                                                ->first();
        }
        //dd($request_copy);

        if(!empty($request_copy)){
            $link = $request_copy->attachment_mask;
            

            // Source file and watermark config
            if($request_copy->documentRevision->documentLibrary->tag == 1){ $fileCategory = 'iso'; }
            elseif($request_copy->documentRevision->documentLibrary->tag == 2){ $fileCategory = 'legal'; }
            elseif($request_copy->documentRevision->documentLibrary->tag == 3){ $fileCategory = 'other'; }
            
            $extension = pathinfo(storage_path('app/public/document/pdf/'.$fileCategory.'/').$link , PATHINFO_EXTENSION);
            $file = storage_path('app/public/document/'.$extension.'/'.$fileCategory.'/').$link;
            $tmpFile = storage_path('app/public/tmp/').auth()->user()->id."_".$link;
            if($request_copy->is_stamped == 1){
                $watermarkFile = storage_path('app/controlledcopy_watermark.pdf');
            } else {
                $watermarkFile = storage_path('app/controlledcopy_blank.pdf');
            }
            
            $owner_password = "owner";
            $user_password = "user";
            
            //User Access
            if($request_copy->documentUserAccess != null || auth()->user()->role == 1){
                //dd($request_copy);
                $pdfPassword1 = new Pdf();
                $pdfPassword2 = new Pdf();
                $pdfPassword3 = new Pdf();

                $pdf = new Pdf();

                if(auth()->user()->role != 1){
                    //Allow Printing
                    $request_copy->documentUserAccess->can_print == 1 ? $allow_printing = "Printing" : $allow_printing = null;
                    //Allow Fill-In
                    $request_copy->documentUserAccess->can_fill == 1 ? $allow_fillin = "FillIn" : $allow_fillin = null;
                } else {
                    $allow_printing = null;
                    $allow_fillin = null;
                }
                

                //Allow Fill-In
                auth()->user()->role == 1 ? $allow_allFeatures = "AllFeatures" : $allow_allFeatures = null;
                
                if($pdfPassword1->addFile($file, 'A', 'ihdcpchi...')->saveAs($tmpFile) === true){
                    $pdfPassword_status = true;
                    $pdfPassword_password = "ihdcpchi...";
                } elseif ($pdfPassword2->addFile($file, 'A', 'pchi...')->saveAs($tmpFile) === true) {
                    $pdfPassword_status = true;
                    $pdfPassword_password = "pchi...";
                } elseif ($pdfPassword3->addFile($file, 'A', 'holdings...')->saveAs($tmpFile) === true) {
                    $pdfPassword_status = true;
                    $pdfPassword_password = "holdings...";
                } else {
                    abort(404, 'Forbidden');
                }

                $result = $pdf/*-> {($pdfPassword_status  === true)  ? 'addFile' : 'setProp3'}($file, 'A', $pdfPassword_password) */
                                ->addFile($file, 'A', $pdfPassword_password)
                                ->allow($allow_printing)
                                ->allow($allow_fillin)
                                ->allow($allow_allFeatures)
                                ->setPassword($owner_password)          // Set owner password
                                ->setUserPassword($user_password)      // Set user password
                                ->passwordEncryption(128)   // Set password encryption strength
                                ->multiStamp($watermarkFile)
                                ->saveAs($tmpFile);
                if ($result === false) {
                    $error = $pdf->getError();
                    echo $error;
                }

                return response()->file($tmpFile);
                
            } else {
                abort(403, 'Forbidden');
            }
        } else {
            abort(403, 'Forbidden');
        }
    }

    public function viewISO($link)
    {
        return view('documents.pdfviewer');
    }
}
