<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class Admin extends Authenticatable
{
    use HasFactory , Notifiable;
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts(){
        return $this->hasMany(Post::class , 'admin_id');
    }

    public function authorization(){
        return $this->belongsTo(Authorization::class , 'role_id');
    }

    public function hasPermissionTo($config_permission){
        $authorization = $this->authorization;
        foreach($authorization->permissions as $permission){
            if($config_permission == $permission){
                return true;
            }
        }
        return false;
    }

    public function receivesBroadcastNotificationsOn(){
        return 'admins.' . $this->id;
    }

}
