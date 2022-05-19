<?php

namespace Modules\Auth\Repositories;

use App\Repositories\Repository;
use DB;

class AuthRepository extends Repository
{
    /**
     * get data admin login
     *
     * @param null $username
     * @return \Illuminate\Support\Collection
     */
    public function get_admin_login($username = null)
    {
        /*
         * define select data
         */
        $select = array(
            'admin.*',
            'admin_groups.name as userlevel',
            'admin_groups.create as role_create',
            'admin_groups.read as role_read',
            'admin_groups.update as role_update',
            'admin_groups.delete as role_delete',
        );

        return DB::table('admin')
            ->leftJoin('admin_groups','admin.guid','=','admin_groups.guid')
            ->where('admin.username',$username)
            ->select(...$select)->get();
    }
}
