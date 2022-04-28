<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etransmittal extends Model
{
    public function getUser(){
        return $this->belongsTo(User::class,'user','id');
    }

    public function getRecipient(){
        return $this->belongsTo(User::class,'recipient','id');
    }

    public function getEtransmittalHistory(){
        return $this->belongsTo(EtransmittalHistory::class,'id','etransmittal_id'); 
    }
}
