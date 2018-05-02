<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permissions')->insert([
            'role_id' => 1,
            'module' => 'user',
            'can_insert' => 1,
            'can_update' => 1,
            'can_delete' => 1,
            'can_view' => 1,
            'is_active' => 1,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
