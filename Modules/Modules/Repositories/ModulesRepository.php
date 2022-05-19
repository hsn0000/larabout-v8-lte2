<?php
namespace Modules\Modules\Repositories;

use App\Repositories\Repository;
use DB;

class ModulesRepository extends Repository
{
    /**
     * process add modules
     *
     * @param array $data
     * @return bool
     */
    public function insert_module(array $data)
    {
        return DB::table('admin_module')->insert($data);
    }

    /**
     * update data module
     *
     * @param $modid
     * @param array $update_data
     * @return bool|int
     */
    public function update_module($modid, array $update_data)
    {
        return DB::table('admin_module')->where(['modid'=>$modid])->update($update_data);
    }

    /**
     * get dropdown parent module
     * @return array
     */
    public function get_dropdown_parent_module()
    {
        /*
        * define variable
        */
        $return[] = "-- Select parent --";
        
        /*
        * get list modules
        */ 
        $parent = Repository()->get_admin_module()
            ->where('published','=','y')
            ->where('parent_id','=','0')
            ->orderBy('mod_order')->get();

        if($parent->isNotEmpty())
        {
            foreach($parent as $item) {
                $return[$item->modid] = $item->mod_name;
            }
        }

        return $return;
    }

    /**
    * get dropdown icon module
    * @return array
    */
    public function get_dropdown_icon_module()
    {
        /*
         * define variable
         */
        $return[] = "-- Select Icon --";

        /*
         * get list modules
         */
        $icon = Repository()->get_icon();


        if($icon->isNotEmpty())
        {
            foreach ($icon as $item) {
                $return[$item->icon] = "<i class='fa $item->icon'></i> ".$item->name;
            }
        }

        return $return;
    }

}