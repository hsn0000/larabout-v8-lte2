<?php

namespace Modules\OperatorGroup\Repositories;

use App\Repositories\Repository;
use DB;

class OperatorGroupRepository extends Repository
{
    /**
     * get operator group table
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function get_operator_group_table()
    {
        return DB::table('admin_groups')
            ->selectRaw('*,IFNULL((select count(1) from admin where admin.guid = admin_groups.guid group by admin.guid ),0) as total_operator');
    }

    /**
     * insert opeartor group data
     *
     * @param $data
     * @return bool
     */
    public function insert_operator_group($data)
    {
        return DB::table('admin_groups')->insert($data);
    }

    /**
     * get oprator group data
     *
     * @param null $key
     * @param null $value
     * @param null $select
     * @return \Illuminate\Support\Collection
     */
    public function get_operator_group($key = null,$value = null,$select = null)
    {
        $select = is_null($select) ? 'admin_groups.*' : $select;

        $query =  DB::table('admin_groups')
            ->selectRaw($select);

        if (is_array($key))
        {
            $query = $query->where($key);
        }
        elseif(!is_null($key) && !is_null($value))
        {
            $query = $query->where($key,$value);
        }
        elseif (!is_null($key) && is_null($value))
        {
            $query = $query->whereRaw($key);
        }

        return  $query->get();
    }

    /**
     * update data operator group
     *
     * @param $guid
     * @param array $update_data
     * @return bool|int
     */
    public function update_operator_group($guid, array $update_data)
    {
        return DB::table('admin_groups')->where(['guid'=>$guid])->update($update_data);
    }

    /**
     * get dropdown operator group data
     *
     * @param null $key
     * @param null $value
     * @return string[]
     */
    public function get_dropdown_operator_group($key = null,$value = null)
    {
        /*
         * define variable
         */
        $return = array(''=>'-- Select Operator Group --');

        /*
         * set selected data
         */
        $query = DB::table('admin_groups')
            ->select('guid','name');

        if (is_array($key))
        {
            $query = $query->where($key);
        }
        elseif(!is_null($key) && !is_null($value))
        {
            $query = $query->where($key,$value);
        }
        elseif (!is_null($key) && is_null($value))
        {
            $query = $query->whereRaw($key);
        }

        /*
         * get data
         */
        $data = $query->get();

        if ($data->count() > 0)
        {
            foreach ($data as $value) {
                $return[$value->guid] = $value->name;
            }
        }

        return $return;
    }

    /**
     * delete operator group data
     *
     * @param $guid
     * @return bool|int
     */
    public function delete_operator_group($guid)
    {
        return DB::table('admin_groups')->where(['guid'=>$guid])->delete();
    }
}
