<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'guid' => 1,
            'fullname' => 'Generator',
            'username' => 'generator',
            'password' => 'gQLCCfORTGEopB6dTQ4=',
            'pin' => '123456',
            'active' => 'n',
        ]);

        DB::table('admin')->where('aid','=',1)->update(['aid'=>0]);
        DB::table('admin')->where('aid','=',2)->update(['aid'=>1]);

        DB::statement("ALTER TABLE admin AUTO_INCREMENT = 1;");

        DB::table('admin')->insert([
            'guid' => 1,
            'fullname' => 'Superadmin',
            'username' => 'superadmin',
            'password' => 'gQLCCfORTGEopB6dTQ4=',
            'pin' => '123456',
            'active' => 'y',
        ]);
    }
}
