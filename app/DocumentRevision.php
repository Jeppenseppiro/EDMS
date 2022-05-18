<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentRevision extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class,'user','id');
    }

    public function documentFileRevision(){
        return $this->hasMany(DocumentFileRevision::class,'document_revision_id','id');
    }
    
    public function documentLibrary(){
        return $this->belongsTo(DocumentLibrary::class,'document_library_id','id');
    }
}
