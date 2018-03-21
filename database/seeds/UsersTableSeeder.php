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
            'name' => 'horan',
            'email' => '15891291118@163.com',
            'password' => bcrypt('123456'),
        ]);
        \App\Models\User::create([
            'name' => '普通用户',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
        ]);
        \App\Models\User::create([
            'name' => '贺钧威',
            'email' => 'hejunwei@hippostudio.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
