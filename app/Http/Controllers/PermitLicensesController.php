<?php

namespace App\Http\Controllers;

use App\PermitLicense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PermitLicensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = explode(",",auth()->user()->role);
        $dateToday = date('Y-m-d');

        $permitandlicenses = PermitLicense::get();
        return view('documents.permittingandlicenses',
            array(
                'permitandlicenses' => $permitandlicenses,
                'dateToday' => $dateToday,
                'role' => $role,
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
            'permitlicense_FileTitle' => ['required'],
            'permitlicense_EffectiveDate' => ['required'],
            'permitlicense_ExpirationDate' => ['required'],
            'permitlicense_Attachment' => ['required'],
        ]);
        
        // Generate Random Code
        $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters  

        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $permitLicense_Code = '';
        foreach (array_rand($seed, 6) as $k) $permitLicense_Code .= $seed[$k];

        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $permitLicense_FilePassword = '';
        foreach (array_rand($seed, 6) as $k) $permitLicense_FilePassword .= $seed[$k];

        // Handle File Upload
        if ($request->hasFile('permitlicense_Attachment')) {
            $fileNameWithExt = $request->file('permitlicense_Attachment')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('permitlicense_Attachment')->getClientOriginalExtension();
            $fileNameToStore = $filename.'.'.$extension;
            
            $path = Storage::putFile('public/document/others', $request->file('permitlicense_Attachment'));
            $path_basename = basename($path);
        }

        $permitLicense = new PermitLicense;
        $permitLicense->code = $permitLicense_Code;
        $permitLicense->file_title = $request->permitlicense_FileTitle;
        $permitLicense->attachment = $fileNameToStore;
        $permitLicense->attachment_mask = $path_basename;
        $permitLicense->file_password = $permitLicense_FilePassword;
        $permitLicense->effective_date = $request->permitlicense_EffectiveDate;
        $permitLicense->expiration_date = $request->permitlicense_ExpirationDate;
        $permitLicense->user = auth()->user()->id;
        $permitLicense->save();

        //return $permitLicense;
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PermitLicense  $permitLicense
     * @return \Illuminate\Http\Response
     */
    public function show(PermitLicense $permitLicense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PermitLicense  $permitLicense
     * @return \Illuminate\Http\Response
     */
    public function edit(PermitLicense $permitLicense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PermitLicense  $permitLicense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PermitLicense $permitLicense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PermitLicense  $permitLicense
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermitLicense $permitLicense)
    {
        //
    }
}
