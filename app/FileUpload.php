<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    public function getTag(){
        return $this->belongsTo(Tag::class,'tag','id');
    }
}
