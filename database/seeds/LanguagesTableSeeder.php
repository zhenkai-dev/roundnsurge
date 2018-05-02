<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name' => 'English',
            'display_name' => 'English',
            'filename' => 'english',
            'code' => 'en',
            'icon' => 'gb.png',
            'ordering' => 0,
            'is_default' => 1,
            'is_active' => 1,
            'updated_at' => current_datetime_string(),
            'created_at' => current_datetime_string()
        ]);
    }
}
