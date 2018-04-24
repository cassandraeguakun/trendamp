<?php

namespace Modules\System\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\System\Events\UserWasCreated;
use Modules\System\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $users = factory(User::class, 12)->make();

        $users->each(function ($user, $index){
            $assignedRoles = [];

            if($index == 0){
                $user->username = 'dennisohere';
                $user->email = 'dennisohere@live.com';

                $assignedRoles[] = config('roles.data.developer');

            } elseif($index == 1){
                $user->username = 'admin';
                $user->email = 'admin@trendamp.com';

                $assignedRoles[] = config('roles.data.admin');
            } else {
                $assignedRoles[] = config('roles.data.user');
            }


            $user->save();

            publish(new UserWasCreated($user, ['roles' => $assignedRoles]));
        });
    }
}
