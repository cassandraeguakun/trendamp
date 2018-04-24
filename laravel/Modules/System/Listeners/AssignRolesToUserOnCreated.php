<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 09/04/2018
 * Time: 05:01 PM
 */

namespace Modules\System\Listeners;


use Modules\System\Events\UserWasCreated;
use Modules\System\Repositories\RolesRepository;

class AssignRolesToUserOnCreated
{
    public function handle(UserWasCreated $event)
    {
        $user = $event->user;

        $assignedRoles = $event->data['roles'] ?? [config('roles.default')];
        $assigned_roles_id = app(RolesRepository::class)->getRolesFromNames($assignedRoles)->pluck('id');

        $user->roles()->attach($assigned_roles_id);
    }

}