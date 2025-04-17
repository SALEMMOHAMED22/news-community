<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'permissions',
    ];

    // accessors
    public function getPermissionsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function admins(){
        return $this->hasMany(Admin::class , 'role_id') ?? 'NO Admins';
    }
}
