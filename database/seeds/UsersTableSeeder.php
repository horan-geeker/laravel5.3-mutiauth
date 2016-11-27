<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => '普通用户',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
