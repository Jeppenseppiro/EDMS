<?php

namespace App\Http\Controllers;
use App\PermitLicense;
use App\DocumentRevision;
use App\DocumentFileRevision;
use App\DocumentLibrary;
use App\Etransmittal;
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
            $revision_file = DocumentFileRevision::with('documentRevision.documentLibrary')
                                                ->where([
                                                    ['attachment_mask', '=', $link],
                                                ])
                                                ->first();
        } else {
            $revision_file = DocumentFileRevision::with('documentUserAccess','documentRevision.documentLibrary')
                                                ->whereHas('documentUserAccess', function ($userAccess) {
                                                    $userAccess->where('user_access', '=', auth()->user()->id);
                                                })
                                                ->where([
                                                    ['attachment_mask', '=', $link],
                                                ])
                                                ->first();
        }
        
        //dd($revision_file);
        
        if(!empty($revision_file)){
            // Source file and watermark config
            if($revision_file->documentRevision->documentLibrary->tag == 1){ $fileCategory = 'iso'; }
            elseif($revision_file->documentRevision->documentLibrary->tag == 2){ $fileCategory = 'legal'; }
            elseif($revision_file->documentRevision->documentLibrary->tag == 3){ $fileCategory = 'other'; }
            
            $extension = $revision_file->attachment;
            $extension = explode(".",$extension);
            $file = storage_path('app/public/document/'.$extension[1].'/'.$fileCategory.'/').$link;
            $tmpFile = storage_path('app/public/tmp/').auth()->user()->id."_".$link;
            if($revision_file->is_stamped == 1){
                $watermarkFile = storage_path('app/controlledcopy_watermark.pdf');
            } else {
                $watermarkFile = storage_path('app/controlledcopy_blank.pdf');
            }
            
            
            //User Access
            if($revision_file->documentUserAccess != null || auth()->user()->role == 1){
                $pdfPassword1 = new Pdf([
                                    'command' => base_path().'\PDFtk\bin\pdftk.exe',
                                    'useExec' => true,
                                ]);
                $pdfPassword2 = new Pdf([
                                    'command' => base_path().'\PDFtk\bin\pdftk.exe',
                                    'useExec' => true,
                                ]);
                $pdfPassword3 = new Pdf([
                                    'command' => base_path().'\PDFtk\bin\pdftk.exe',
                                    'useExec' => true,
                                ]);

                $pdf = new Pdf();

                if(auth()->user()->role != 1){
                    //Allow Printing
                        $revision_file->documentUserAccess->can_print == 1 ? $allow_printing = "Printing" : $allow_printing = null;
                        //Allow Fill-In
                        $revision_file->documentUserAccess->can_fill == 1 ? $allow_fillin = "FillIn" : $allow_fillin = null;
                    } else {
                        $allow_printing = null;
                        $allow_fillin = null;
                    }
                    
                    if($extension[1] == 'pdf'){
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

                    $owner_password = $pdfPassword_password;
                    $user_password = $revision_file->file_password;

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
                    return response()->download($file);
                }
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
        //dd($request_copy->documentRevision->documentLibrary->requestIsoCopy);

        if(!empty($request_copy)){
            $date1 = date('Y-m-d', time());
            $date2 = $request_copy->documentRevision->documentLibrary->requestIsoCopy->requestIsoCopyHistory->date_expiration;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $difference = $timestamp2 - $timestamp1;
            $days = $difference/(24*60*60);

            if($days >= 0){
                $link = $request_copy->attachment_mask;
                // Source file and watermark config
                if($request_copy->documentRevision->documentLibrary->tag == 1){ $fileCategory = 'iso'; }
                elseif($request_copy->documentRevision->documentLibrary->tag == 2){ $fileCategory = 'legal'; }
                elseif($request_copy->documentRevision->documentLibrary->tag == 3){ $fileCategory = 'other'; }
                
                $extension = $request_copy->attachment_mask;
                $extension = explode(".",$extension);
                $file = storage_path('app/public/document/'.$extension[1].'/'.$fileCategory.'/').$link;
                $tmpFile = storage_path('app/public/tmp/').auth()->user()->id."_".$link;
                $headers = [
                    'Content-Type' => 'application/'.$extension[1],
                ];

                
                if($request_copy->is_stamped == 1){
                    $watermarkFile = storage_path('app/controlledcopy_watermark.pdf');
                } else {
                    $watermarkFile = storage_path('app/controlledcopy_blank.pdf');
                }
                
                //User Access
                if($request_copy->documentUserAccess != null || auth()->user()->role == 1){
                    //dd($request_copy);
                    $pdfPassword1 = new Pdf([
                                    'command' => base_path().'\PDFtk\bin\pdftk.exe',
                                    'useExec' => true,
                                ]);
                    $pdfPassword2 = new Pdf([
                                    'command' => base_path().'\PDFtk\bin\pdftk.exe',
                                    'useExec' => true,
                                ]);
                    $pdfPassword3 = new Pdf([
                                    'command' => base_path().'\PDFtk\bin\pdftk.exe',
                                    'useExec' => true,
                                ]);

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
                    

                    if($extension[1] == 'pdf'){
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

                        $owner_password = $pdfPassword_password;
                        $user_password = $request_copy->file_password;

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
                        return response()->download($tmpFile);
                    }
                    
                    
                } else {
                    abort(403, 'Forbidden');
                }
            } else {
                abort(403, 'Link Expired');
            }

            
        } else {
            abort(403, 'Forbidden');
        }
    }

    public function etransmittalFile($link)
    {
        $etransmittal = Etransmittal::where([['attachment_mask', '=', $link],])->first();
        $extension = $etransmittal->attachment;
        $extension = explode(".",$extension);

        $file = storage_path('app/public/etransmittal/'.$extension[1 ].'/'.$etransmittal->attachment_mask);

        if($extension[1] == 'pdf'){
            return response()->file($file);
        } else {
            return response()->download($file);
        }
    }

    public function permittingLicenses($link)
    {
        $permittingLicense = PermitLicense::where([['attachment_mask', '=', $link],])->first();
        $extension = $permittingLicense->attachment;
        $extension = explode(".",$extension);

        //dd($revision_file);
        $file = storage_path('app/public/document/others/'.$permittingLicense->attachment_mask);

        if($extension[1] == 'pdf'){
            return response()->file($file);
        } else {
            return response()->download($file);
        }
    }
}
