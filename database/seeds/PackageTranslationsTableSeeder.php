<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PackageTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('package_translations')->insert([
            'package_id' => 1,
            'language_id' => 1,
            'name' => 'Basic use',
            'description' => '<p>Lorem ipsum</p>',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('package_translations')->insert([
            'package_id' => 2,
            'language_id' => 1,
            'name' => 'Member',
            'description' => '<p>Lorem ipsum</p>',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('package_translations')->insert([
            'package_id' => 3,
            'language_id' => 1,
            'name' => 'Pro',
            'description' => '<p>Lorem ipsum</p>',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('friendly_urls')->insert([
            'fkid' => 1,
            'module' => 'App\Package',
            'name' => 'basic',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('friendly_urls')->insert([
            'fkid' => 2,
            'module' => 'App\Package',
            'name' => 'member',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('friendly_urls')->insert([
            'fkid' => 3,
            'module' => 'App\Package',
            'name' => 'pro',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
