<?php

namespace Modules\System\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $guarded = 'id';

    public function users()
    {
        return $this->belongsToMany(User::class,'user_roles_pivot','permission_id','user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Permission::class,'user_permissions_pivot','permission_id','role_id');
    }
}
