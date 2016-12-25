<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Models\Admin::create([
            'name'     => '超级管理员',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('admin123'),
        ]);

        $permissions = [
            ['name' => 'admin module', 'description' => '管理员管理', 'uri' => '/admin/managers', 'title' => '后台管理'],
            ['name' => 'user module', 'description' => '用户管理', 'uri' => '/admin/users', 'title' => '前台管理'],
        ];

        Permission::insert($permissions);

        $admin->permissions()->saveMany([
            Permission::find(1),
            Permission::find(2),
        ]);

        $user = \App\Models\Admin::create([
            'name'     => '用户管理员',
            'email'    => 'user@admin.com',
            'password' => bcrypt('admin123'),
        ]);

        $user->permissions()->save(Permission::find(2));
    }
}
