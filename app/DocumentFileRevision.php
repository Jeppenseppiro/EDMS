<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentFileRevision extends Model
{
    public function documentRevision(){
        return $this->belongsTo(DocumentRevision::class, 'document_revision_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user','id');
    }

    public function documentUserAccess(){
        return $this->belongsTo(DocumentFileRevisionAccess::class,'id','document_file_revision_id');
    }

    public function manyUserAccess(){
        return $this->hasMany(DocumentFileRevisionAccess::class,'document_file_revision_id','id');
    }
}