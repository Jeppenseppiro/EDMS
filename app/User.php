<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCompany(){
        return $this->belongsTo(Company::class, 'company', 'id');
    }

    public function getDepartment(){
        return $this->belongsTo(Department::class, 'department', 'id');
    }

    public function getRole(){
        return $this->belongsTo(Role::class, 'role', 'id');
    }

    public function getUserAccess(){
        return $this->belongsTo(DocumentLibraryAccess::class, 'user_access', 'id');
    }
}
