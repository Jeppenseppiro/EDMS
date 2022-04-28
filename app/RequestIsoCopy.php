<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestIsoCopy extends Model
{
    public function requestor(){
        return $this->belongsTo(User::class,'user','id');
    }

    public function documentRequested(){
        return $this->belongsTo(DocumentLibrary::class,'document_library_id','id');
    }

    public function requestCopyType(){
        return $this->belongsTo(RequestIsoCopyType::class,'copy_type','id');
    }

    public function requestIsoCopyHistory(){
        return $this->belongsTo(RequestCopyHistory::class,'id','request_copy_id');
    }

    public function requestIsoCopyLatestHistory(){
        return $this->belongsTo(RequestCopyHistory::class,'id','request_copy_id')
                    ->join('request_iso_copy_statuses', 'request_copy_histories.status', '=', 'request_iso_copy_statuses.id')
                    ->where('request_copy_histories.tag', '=', '1'); 
    }

    public function requestCopyExpiration(){
        return $this->belongsTo(RequestCopyHistory::class,'id','request_copy_id');
                    //->join('users', 'request_iso_copies.user', '=', 'users.id');
    }
}
