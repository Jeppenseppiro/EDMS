<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestIsoEntry extends Model
{
    //

    public function user(){
        return $this->belongsTo(User::class,'requestor_name','id');
    }

    public function requestType(){
        return $this->belongsTo(RequestType::class,'request_type','id');
    }
    
    public function documentType(){
        return $this->belongsTo(DocumentCategory::class,'document_type','id');
    }

    public function documentToRevise(){
        return $this->belongsTo(DocumentLibrary::class,'document_to_revise','id');
    }

    public function requestStatus(){
        return $this->belongsTo(RequestEntryStatus::class,'status','id');
    }

    /* public function requestIsoEntryHistory(){
        return $this->hasMany(RequestIsoEntryHistory::class,'request_iso_entry_id','id');
    } */

    public function requestIsoEntryLatestHistory(){
        return $this->belongsTo(RequestIsoEntryHistory::class,'id','request_iso_entry_id')
                    ->join('request_entry_statuses', 'request_iso_entry_histories.status', '=', 'request_entry_statuses.id');
    }
}
