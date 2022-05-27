<?php

namespace App\Http\Controllers;

use App\Etransmittal;
use App\EtransmittalHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class EtransmittalsController extends Controller
{
    public function index()
    {
        $role = explode(",",auth()->user()->role);
        $dateToday = date('Y-m-d');

        $etransmittals = Etransmittal::with('getUser.getCompany','getUser.getDepartment','getRecipient.getCompany','getRecipient.getDepartment','getEtransmittalHistory')
                                        ->when(!in_array(1, $role), function ($query) {
                                            $query->where('user', '=', auth()->user()->id)
                                            ->orWhere('recipient', '=', auth()->user()->id);
                                        })
                                        ->get();
                                        
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('documents.etransmittal',
            array(
                'users' => $users,
                'etransmittals' => $etransmittals,
                'role' => $role,
                'dateToday' => $dateToday,
            )
        );
    }
    
    public function store(Request $request)
    {
        $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters  
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $requestCopy_Code = '';
        foreach (array_rand($seed, 6) as $k) $requestCopy_Code .= $seed[$k];
        
        $etransmittal = new Etransmittal;
        $etransmittal->code = sprintf('%03d', $etransmittal->insert_id);
        $etransmittal->user = auth()->user()->id;
        $etransmittal->item = $request->etransmittal_Item;
        $etransmittal->recipient = $request->etransmittal_Recipient;
        $etransmittal->save();

        $etransmittal_History = new EtransmittalHistory;
        $etransmittal_History->etransmittal_id = $etransmittal->id;
        if ($request->hasFile('etransmittal_Attachment')) {
            $fileNameWithExt = $request->etransmittal_Attachment->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->etransmittal_Attachment->getClientOriginalExtension();
            $fileNameToStore = $filename . '.' . $extension;

            $path = Storage::putFile('public/etransmittal/'.$extension.'/', $request->etransmittal_Attachment);
            $path_basename = basename($path);

            $etransmittal_History->attachment = $fileNameToStore;
            $etransmittal_History->attachment_mask = $path_basename;
        }
        $etransmittal_History->status = $request->etransmittal_Status;
        $etransmittal_History->user = auth()->user()->id;
        $etransmittal_History->save();

        return redirect()->back();
    }

    public function history_store(Request $request){
        $etransmittal_History = new EtransmittalHistory;
        $etransmittal_History->etransmittal_id = $request->updateEtransmittal_ID;

        if ($request->hasFile('updateEtransmittal_Attachment')) {
            $fileNameWithExt = $request->updateEtransmittal_Attachment->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->updateEtransmittal_Attachment->getClientOriginalExtension();
            $fileNameToStore = $filename . '.' . $extension;

            $path = Storage::putFile('public/etransmittal/'.$extension.'/', $request->updateEtransmittal_Attachment);
            $path_basename = basename($path);

            $etransmittal_History->attachment = $fileNameToStore;
            $etransmittal_History->attachment_mask = $path_basename;
        }

        $etransmittal_History->status = $request->updateEtransmittal_Status;
        $etransmittal_History->remarks = $request->updateEtransmittal_Remarks;
        $etransmittal_History->user = auth()->user()->id;
        $etransmittal_History->save();

        return redirect()->back();
    }

    public function history_view($etransmittalID){
        $etransmittal_HistoryShow = EtransmittalHistory::with('getUser')
                                    ->where([
                                        ['etransmittal_id', '=', $etransmittalID]
                                    ])
                                    ->orderBy('id', 'DESC')->get();
        return $etransmittal_HistoryShow;
    }
}
