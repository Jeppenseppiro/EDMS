<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestCopyHistory extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class,'user','id');
    }

    public function userRequestor(){
        return $this->belongsTo(User::class,'requestor','id');
    }

    public function requestIsoCopy(){
        return $this->belongsTo(RequestIsoCopy::class,'request_copy_id','id');
    }

    public function requestStatus(){
        return $this->belongsTo(RequestIsoCopyStatus::class,'status','id');
    }

    public function requestCopyExpiration(){
        return $this->belongsTo(RequestIsoCopy::class,'request_copy_id','id')
                    //->join('document_revisions', 'request_iso_copies.document_library_id', '=', 'document_revisions.document_library_id')
                    ;
                    //->join('users', 'request_iso_copies.user', '=', 'users.id');
                    //->join('document_libraries', 'request_iso_copies.document_library_id', '=', 'document_libraries.id');
    }
}
