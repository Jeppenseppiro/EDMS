<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestLegalEntry extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class,'requestor_name','id');
    }

    public function documentType(){
        return $this->belongsTo(DocumentCategory::class,'document_type','id');
    }

    public function requestStatus(){
        return $this->belongsTo(RequestEntryStatus::class,'status','id');
    }
}
