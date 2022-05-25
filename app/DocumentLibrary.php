<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentLibrary extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class,'user','id');
    }

    public function documentCategory(){
        return $this->belongsTo(DocumentCategory::class, 'category', 'id');
    }

    public function documentTag(){
        return $this->belongsTo(Tag::class, 'tag', 'id');
    }

    public function documentDepartment(){
        return $this->belongsTo(Department::class, 'department', 'id');
    }

    public function documentCompany(){
        return $this->belongsTo(Company::class, 'company', 'id');
    }

    public function documentRevision(){
        return $this->belongsTo(DocumentRevision::class, 'id', 'document_library_id');
    }

    public function documentMultipleRevision(){
        return $this->hasMany(DocumentRevision::class, 'document_library_id', 'id')/* ->where('is_obsolete', 0) */->orderBy('id', 'DESC');
    }

    public function documentLatestMultipleRevision(){
        return $this->hasMany(DocumentRevision::class, 'document_library_id', 'id')->orderBy('id', 'DESC');
    }

    public function documentAccess(){
        return $this->hasMany(DocumentLibraryAccess::class,'document_library_id','id');
    }

    public function requestIsoCopy(){
        return $this->belongsTo(RequestIsoCopy::class,'id','document_library_id');
    }

    /* public function getRequestIsoEntry(){
        return $this->belongsTo(RequestIsoEntry::class, 'id', 'document_to_revise')
                    ->join('request_types', 'request_iso_entries.request_type', '=', 'request_types.id')
                    ->join('request_entry_histories', 'request_iso_entries.id', '=', 'request_entry_histories.request_iso_entry_id')
                    ->join('request_entry_statuses', 'request_entry_histories.status', '=', 'request_entry_statuses.id');
    } */

}
