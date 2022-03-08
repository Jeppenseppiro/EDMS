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
                    //->join('document_categories', 'document_libraries.category', '=', 'document_categories.id');
    }

    public function requestStatus(){
        return $this->belongsTo(RequestEntryStatus::class,'status','id');
    }


    public function requestIsoEntryLatestHistory(){
        return $this->belongsTo(RequestEntryHistory::class,'id','request_iso_entry_id')
                    ->join('request_entry_statuses', 'request_entry_histories.status', '=', 'request_entry_statuses.id')
                    ->where('request_entry_histories.tag', '=', '1');
    }
}
