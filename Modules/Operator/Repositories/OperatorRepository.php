<?php
namespace Modules\Operator\Repositories;

use App\Repositories\Repository;
use DB;

class OperatorRepository extends Repository
{
    /**
     * get data operator
     *
     * @param null $key
     * @param null $value
     * @param null $select
     * @return \Illuminate\Support\Collection
     */
    public function get_operator($key = null,$value = null,$select = null)
    {
        $select = is_null($select) ? '*' : $select;

        $query = DB::table('admin')
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

        return $query;
    }

    /**
     * get data all operator
     *
     * @param null $key
     * @param null $value
     * @param null $select
     * @return \Illuminate\Support\Collection
     */
    public function get_all_operator($key = null,$value = null,$select = null)
    {
        $select = is_null($select) ? 'admin.*, admin_groups.name as `group`' : $select;

        $query =  DB::table('admin')
            ->selectRaw($select)
            ->leftJoin('admin_groups','admin.guid','=','admin_groups.guid');

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

        return  $query;
    }

    /**
     * generate operator query for data table
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function get_operator_table()
    {
        return DB::table('admin')
            ->selectRaw('admin.*, admin_groups.name as `group`')
            ->leftJoin('admin_groups','admin.guid','=','admin_groups.guid')
            ->where('aid','!=',0);
    }

    /**
     * check username exist
     *
     * @param string $username
     * @return bool
     */
    public function username_exist(string $username)
    {
        return DB::table('admin')
            ->where('username','=',$username)
            ->get()
            ->isNotEmpty();
    }

    /**
     * process add operator
     *
     * @param array $data
     * @return bool
     */
    public function insert_operator(array $data)
    {
        return DB::table('admin')->insert($data);
    }

    /**
     * update data operator
     *
     * @param $aid
     * @param array $update_data
     * @return bool|int
     */
    public function update_operator($aid, array $update_data)
    {
        return DB::table('admin')->where(['aid'=>$aid])->update($update_data);
    }

    /**
     * delete operator data
     *
     * @param $aid
     * @return bool|int
     */
    public function delete_operator($aid)
    {
        return DB::table('admin')->where(['aid'=>$aid])->delete();
    }
}
