<?php

namespace App\Repositories;
use DB;

use Illuminate\Support\Collection;

class Repository
{
    /**
     * set page limit pagination
     *
     * @var int
     */
    public int $page_limit = 50;

    /**
     * get admin module data
     *
     * @param null $key
     * @param null $value
     * @param null $select
     * @return Collection
     */
    public function get_admin_module($key = null,$value = null,$select = null)
    {
        $select = is_null($select) ? 'admin_module.*' : $select;
        /*
        * get data from db
        */
        $query =  DB::table('admin_module')
            ->selectRaw($select)
            ->orderBy('mod_order','asc');

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
     * get icon
     *
     * @param null $key
     * @param null $value
     * @param null $select
     * @return Collection
     */
    public function get_icon($key = null,$value = null,$select = null)
    {
        $select = is_null($select) ? '*' : $select;

        // if($this->redis()->has('data:icon'))
        // {
        //     /*
        //      * get data from redis
        //      */
        //     $data =  collect(json_decode($this->redis()->get('data:icon')));
        // }
        // else
        // {
        //     /*
        //      * get data from db
        //      */
        //     $data =  DB::table('fontawesome')->get();

        //     $this->redis()->set('data:icon',json_encode($data),env('REDIS_CACHE_TIME',3600));

        // }

        $data =  DB::table('fontawesome')->get();

        if(is_array($select))
        {
            $data = $data->only(...$select);
        }
        elseif(!is_null($select) && $select !== '*')
        {
            $select = explode(',',$select);
            $data = $data->only(...$select);
        }

        if(!is_null($key) && !is_null($value) && !is_array($key))
        {
            $data = $data->where($key,$value);
        }

        return $data;
    }

    /**
     * insert admin log
     *
     * @param string $type
     * @param string $aid
     * @param string $value
     * @return bool
     */
    public function admin_log(string $type = '',string $aid = '', string $value = '')
    {
        /*
         * define table name
         */
        $table_name = 'admin_log';
        $value = !is_string($value) ? json_encode($value) : $value;

        if($type)
        {
            /*
             * define variable
             */
            $aid            = isset($aid) && $aid !== '' ? $aid : (isset(general()->user_active()->aid) ? general()->user_active()->aid : 0 );
            $replace_log    = array('login', 'logout');

            if(in_array($type, $replace_log))
            {
                $this->delete_table($table_name, array('type' => $type, 'aid' => $aid));
            }

            $insert_data = array(
                'aid' => $aid,
                'ip_address' => request()->getClientIp(),
                'type' => $type,
                'value' => $value ?? NULL
            );

            return $this->insert_table($table_name, $insert_data);
        }

        return false;
    }

}
