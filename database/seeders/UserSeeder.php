<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Administrator';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make(123456);
        $user->role_as = 1;
        $user->save();

        $user = new User();
        $user->name = 'Test One';
        $user->email = 'test1@test.com';
        $user->password = Hash::make(123456);
        $user->save();

        $user = new User();
        $user->name = 'Test Two';
        $user->email = 'test2@test.com';
        $user->password = Hash::make(123456);
        $user->save();

        $user = new User();
        $user->name = 'Test Three';
        $user->email = 'test3@test.com';
        $user->password = Hash::make(123456);
        $user->save();

        $user = new User();
        $user->name = 'Test Four';
        $user->email = 'test4@test.com';
        $user->password = Hash::make(123456);
        $user->save();

        $user = new User();
        $user->name = 'Test Five';
        $user->email = 'test5@test.com';
        $user->password = Hash::make(123456);
        $user->save();


    }
}
