<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestEntryHistory extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class,'user','id');
    }

    public function requestIsoEntry(){
        return $this->belongsTo(RequestIsoEntry::class,'request_iso_entry_id','id');
    }

    public function requestStatus(){
        return $this->belongsTo(RequestEntryStatus::class,'status','id');
    }
}
