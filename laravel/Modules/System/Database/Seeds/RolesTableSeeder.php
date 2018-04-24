<?php

namespace Modules\System\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\System\Models\Role;
use Modules\System\Utilities\Helper;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $roles_config = config('roles.data');

        foreach ($roles_config as $role){
            Role::create([
               'name' => $role
            ]);
        }
    }
}
