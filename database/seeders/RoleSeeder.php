<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
            	'name' => 'Admin',
            	'slug' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
            	'name' => 'Staff',
            	'slug' => 'staff',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
