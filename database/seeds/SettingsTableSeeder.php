<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'site_name' => 'Owl.My CMS',
            'logo' => 'logo.png',
            'enquiry_receiver' => 'kitloong1008@gmail.com',
            'smtp' => 0,
            'default_meta_title' => 'Owl.My CMS',
            'updated_at' => current_datetime_string(),
            'created_at' => current_datetime_string()
        ]);
    }
}
