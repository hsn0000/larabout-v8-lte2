<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminGroups extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_groups')->insert([
            'name' => 'Superadmin',
            'create' => '["*"]',
            'read' => '["*"]',
            'update' => '["*"]',
            'delete' => '["*"]'
        ]);
    }
}
