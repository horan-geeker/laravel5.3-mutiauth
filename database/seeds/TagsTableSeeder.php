<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tag::create([
            'type' => 'UI/UX'
        ]);
        \App\Models\Tag::create([
            'type' => '后端'
        ]);
        \App\Models\Tag::create([
            'type' => '前端'
        ]);
        \App\Models\Tag::create([
            'type' => '运维'
        ]);
    }
}
