<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($n = 0; $n <= 100; $n++) {
            DB::table('members')->insert([
                'name' => 'Member ' . $n,
                'email' => 'member' . $n . '@owl.my',
                'password' => bcrypt('password'),
                'mobile' => (123456789 + $n),
                'dob' => '1990-01-02',
                'added_by' => 1,
                'is_active' => 1,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
