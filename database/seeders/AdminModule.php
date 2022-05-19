<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminModule extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_module')->insert(
            [
                [
                    'parent_id' => 0,
                    'mod_order' => 0,
                    'mod_name' => 'Dashboard',
                    'mod_alias' => 'dashboard',
                    'mod_icon' => 'fa fa-home',
                    'permalink' => '/',
                    'published' => 'y',
                ],
                [
                    'parent_id' => 0,
                    'mod_order' => 1,
                    'mod_name' => 'Account',
                    'mod_alias' => 'account',
                    'mod_icon' => 'fa fa-users',
                    'permalink' => '/account',
                    'published' => 'y',
                ],
                [
                    'parent_id' => 2,
                    'mod_order' => 0,
                    'mod_name' => 'User',
                    'mod_alias' => 'user',
                    'mod_icon' => null,
                    'permalink' => '/user',
                    'published' => 'y',
                ],
                [
                    'parent_id' => 0,
                    'mod_order' => 2,
                    'mod_name' => 'Tools',
                    'mod_alias' => 'tools',
                    'mod_icon' => 'fa fa-wrench',
                    'permalink' => '/tools',
                    'published' => 'y',
                ],
                [
                    'parent_id' => 0,
                    'mod_order' => 3,
                    'mod_name' => 'Web Settings',
                    'mod_alias' => 'web-settings',
                    'mod_icon' => 'fa fa-globe',
                    'permalink' => '/web-settings',
                    'published' => 'y',
                ],
                [
                    'parent_id' => 0,
                    'mod_order' => 4,
                    'mod_name' => 'Master Settings',
                    'mod_alias' => 'master-settings',
                    'mod_icon' => 'fa fa-cogs',
                    'permalink' => '/master-settings',
                    'published' => 'y',
                ],
                [
                    'parent_id' => 6,
                    'mod_order' => 1,
                    'mod_name' => 'Operator',
                    'mod_alias' => 'operator',
                    'mod_icon' => null,
                    'permalink' => '/operator',
                    'published' => 'y',
                ],
                [
                    'parent_id' => 6,
                    'mod_order' => 2,
                    'mod_name' => 'Operator Groups',
                    'mod_alias' => 'operator-group',
                    'mod_icon' => null,
                    'permalink' => '/operator-group',
                    'published' => 'y',
                ],
                [
                    'parent_id' => 6,
                    'mod_order' => 3,
                    'mod_name' => 'Modules',
                    'mod_alias' => 'modules',
                    'mod_icon' => null,
                    'permalink' => '/modules',
                    'published' => 'y',
                ],
            ]
        );
    }
}
