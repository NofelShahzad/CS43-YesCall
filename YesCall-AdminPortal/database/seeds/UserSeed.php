<?php

use App\Rule;
use App\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_user=Rule::where('name','User')->first();
        $role_admin=Rule::where('name','Admin')->first();


        $user1=new User();
        $user1->name="Hamza";
        $user1->email='hamza@gmail.com';
        $user1->password=bcrypt('hamza123');
        $user1->api_token=str_random(60);
        $user1->save();
        $user1->roles()->attach($role_admin);
        $user1->roles()->attach($role_user);


    }


}
