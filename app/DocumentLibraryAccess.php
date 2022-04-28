<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentLibraryAccess extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'user','id');
    }
    
    public function userAccess(){
        return $this->belongsTo(User::class,'user_access','id');
    }

    public function documentAccess(){
        return $this->belongsTo(DocumentLibrary::class,'document_library_id','id');
    }
}
