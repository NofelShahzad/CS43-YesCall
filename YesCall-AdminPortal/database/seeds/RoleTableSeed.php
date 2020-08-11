<?php

use App\Rule;
use Illuminate\Database\Seeder;

class RoleTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_user=new Rule();
        $role_user->name='Admin';
        $role_user->description='A Normal Student User';
        $role_user->save();

        $role_auther=new Rule();
        $role_auther->name='User';
        $role_auther->description='An Admin User';
        $role_auther->save();
        }
}
