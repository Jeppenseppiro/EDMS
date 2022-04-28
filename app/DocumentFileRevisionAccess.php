<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentFileRevisionAccess extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'user','id');
    }
    
    public function userAccess(){
        return $this->belongsTo(User::class,'user_access','id');
    }

    public function documentFileRevision(){
        return $this->belongsTo(DocumentFileRevision::class,'document_file_revision_id','id');
    }

    public function documentAccess(){
        return $this->belongsTo(DocumentLibrary::class,'document_library_id','id');
    }
}
