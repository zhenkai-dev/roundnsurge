<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->insert([
            'currency_id' => 1,
            'currency_code' => 'MYR',
            'currency_symbol' => 'RM',
            'currency_format' => 'RM1,0.00',
            'currency_exchange_rate' => '1',
            'package_type' => 'basic',
            'price' => 0,
            'is_active' => true,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('packages')->insert([
            'currency_id' => 1,
            'currency_code' => 'MYR',
            'currency_symbol' => 'RM',
            'currency_format' => 'RM1,0.00',
            'currency_exchange_rate' => '1',
            'package_type' => 'member',
            'price' => 3888,
            'is_active' => true,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('packages')->insert([
            'currency_id' => 1,
            'currency_code' => 'MYR',
            'currency_symbol' => 'RM',
            'currency_format' => 'RM1,0.00',
            'currency_exchange_rate' => '1',
            'package_type' => 'pro',
            'price' => 6888,
            'is_active' => true,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
