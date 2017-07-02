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
            'email'    => '13571899655@163.com',
            'password' => bcrypt('123456'),
        ]);

        $permissions = [
            ['name' => 'admin module', 'description' => '管理员管理', 'uri' => '/admin/managers', 'title' => '后台管理'],
            ['name' => 'user module', 'description' => '用户管理', 'uri' => '/admin/users', 'title' => '前台管理'],
            ['name' => 'schedule module', 'description' => '定期任务', 'uri' => '/admin/schedules', 'title' => '任务管理'],
        ];

        Permission::insert($permissions);

        $admin->permissions()->saveMany(Permission::all());

        $user = \App\Models\Admin::create([
            'name'     => '用户管理员',
            'email'    => 'user@admin.com',
            'password' => bcrypt('admin123'),
        ]);

        $user->permissions()->save(Permission::find(2));
    }
}
