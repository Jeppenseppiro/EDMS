<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentLibrary extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class,'requestor','id');
    }

    public function documentCategory(){
        return $this->belongsTo(DocumentCategory::class, 'category', 'id');
    }

    public function documentTag(){
        return $this->belongsTo(Tag::class, 'tag', 'id');
    }

    public function getRequestIsoEntry(){
        return $this->belongsTo(RequestIsoEntry::class, 'id', 'document_to_revise')
                    ->join('request_types', 'request_iso_entries.request_type', '=', 'request_types.id')
                    ->join('request_entry_histories', 'request_iso_entries.id', '=', 'request_entry_histories.request_iso_entry_id')
                    ->join('request_entry_statuses', 'request_entry_histories.status', '=', 'request_entry_statuses.id');
    }

}
