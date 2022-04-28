<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtransmittalHistory extends Model
{
    public function getUser(){
        return $this->belongsTo(User::class,'user','id');
    }
}
