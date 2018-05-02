<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FriendlyUrlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('friendly_urls')->insert([
            'fkid' => 1,
            'module' => 'App\Page',
            'name' => 'home',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
