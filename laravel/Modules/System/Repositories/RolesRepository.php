<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 09/04/2018
 * Time: 05:03 PM
 */

namespace Modules\System\Repositories;


use Modules\System\Models\Role;

class RolesRepository
{
    /**
     * @var Role
     */
    private $role;


    /**
     * RolesRepository constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getRolesFromNames(array $role_names)
    {
        return $this->role->whereIn('name', $role_names)->get();
    }
}