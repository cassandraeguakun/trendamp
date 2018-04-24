<?php

namespace Modules\System\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $guarded = 'id';

    public function users()
    {
        return $this->belongsToMany(User::class,'user_roles_pivot','role_id','user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'user_permissions_pivot','role_id','permission_id');
    }
}
