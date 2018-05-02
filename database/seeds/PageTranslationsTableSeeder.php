<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PageTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Home', 'About us', 'Our history', 'Portfolio', 'Contact us'];

        DB::table('page_translations')->insert([
            'page_id' => 1,
            'language_id' => 1,
            'name' => 'Home',
            'description' => '<p>Page Description</p>',
            'meta_title' => 'Meta title',
            'meta_keywords' => 'Meta keywords',
            'meta_description' => 'Meta description',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
