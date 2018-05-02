<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MenuTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Home', 'About us', 'Our history', 'Portfolio', 'Contact us'];

        DB::table('menu_translations')->insert([
            'menu_id' => 1,
            'language_id' => 1,
            'name' => 'Home',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
