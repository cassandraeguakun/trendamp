<?php

namespace Modules\System\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\System\Contracts\IMetaData;
use Modules\System\Contracts\MetaDataTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements IMetaData, JWTSubject
{
    use Notifiable, MetaDataTrait, HasApiTokens;

    protected $table = 'users';

    protected $guarded = ['id'];

    protected $dates = [
        'registered_at'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function setPassword($password)
    {
        return $this->update(['password' => bcrypt($password)]);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_roles_pivot','user_id','role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'user_permissions_pivot','user_id','permission_id');
    }
}
