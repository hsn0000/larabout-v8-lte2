<?php

namespace App\Library;

use Nwidart\Menus\Facades\Menu as MainMenu;

class Modules
{
    /**
     * get module data
     *
     * @param bool $object
     * @param bool $all_data
     * @return \Illuminate\Support\Collection|array
     */
    public function get_module(bool $object = TRUE,bool $all_data = FALSE)
    {
     
     
        if(!!$all_data)
        {
            // $parent = Repository()->get_admin_module()->where('parent_id','=','0')->sortBy('mod_order')->toArray();
            $parent = Repository()->get_admin_module()->where('parent_id','=','0')->orderBy('mod_order')->get()->toArray();
        }
        else
        {
            $parent = Repository()->get_admin_module()->where('parent_id','=','0')->where('published','y')->orderBy('mod_order')->get()->toArray();
        }

        $data = array();

        foreach($parent as $value)
        {
            $value = (object) $value;

            if($value->published == "y" || $all_data)
            {
                $data[$value->modid] = $value;
                $data[$value->modid]->{'detail'} = array();

                if($all_data)
                {
                    // $detail = Repository()->get_admin_module()->where('parent_id','=',$value->modid)->sortBy('mod_order')->toArray();
                    $detail = Repository()->get_admin_module()->where('parent_id','=',$value->modid)->orderBy('mod_order')->get()->toArray();
                }
                else
                {
                    $detail = Repository()->get_admin_module()->where('published','=','y')->where('parent_id','=',$value->modid)->orderBy('mod_order')->get()->toArray();
                }

                foreach($detail as $val)
                {
                    $data[$value->modid]->{'detail'}[] = $val;
                }
            }

        }

        if($object)
        {
            // return collect(json_encode(json_decode($data)));
            return $data;
        }
        else
        {
            return $data;
        }

    }


    /**
     * generate sidebar
     */
    public function generate_sidebar()
    {
        MainMenu::create('sidebar', function($menu) {
            $menu->style('adminlte');

            $module = $this->get_module(FALSE);

            foreach($module as $item)
            {
                if(count($item->detail) > 0)
                {
                    $mod_access = FALSE;

                    foreach($item->detail as $child)
                    {
                        $checkmod_access = $this->module_access($child->mod_alias);
                        
                        if($checkmod_access)
                        {
                            $mod_access = TRUE;
                        }
                    }

                    if($mod_access)
                    {
                        $menu->dropdown($item->mod_name, function($sub) use ($item) {
                            $sub->url = preg_replace('/'.preg_quote('/', '/').'/', '', $item->permalink, 1) === "" ? "/" : preg_replace('/'.preg_quote('/', '/').'/', '', $item->permalink, 1);
                            $sub->title = $item->mod_name;
                            $sub->icon = $item->mod_icon;

                            foreach ($item->detail as $child)
                            {
                                if($this->module_access($child->mod_alias))
                                {
                                    $sub->add([
                                        'url' => preg_replace('/'.preg_quote('/', '/').'/', '', $child->permalink, 1) === "" ? "/" : preg_replace('/'.preg_quote('/', '/').'/', '', $child->permalink, 1),
                                        'title' => $child->mod_name,
                                        'icon' => 'fa fa-circle-o'
                                    ]);
                                }
                            }
                        });
                    }
                }
                else
                {
                    if($this->module_access($item->mod_alias))
                    {
                        $menu->add([
                            'url' => preg_replace('/'.preg_quote('/', '/').'/', '', $item->permalink, 1) === "" ? "/" : preg_replace('/'.preg_quote('/', '/').'/', '', $item->permalink, 1),
                            'title' => $item->mod_name,
                            'icon' => $item->mod_icon
                        ]);
                    }
                }
            }
        });
    }

    /**
     * get title module
     *
     * @param string $alias
     * @param string $role
     * @param bool $icon
     * @return string|null
     */
    public function generate_title(string $alias = "", string $role = "read", bool $icon = TRUE)
    {
        /*
        * define variable
        */
        $module = Repository()->get_admin_module();

        /*
        * find module
        */
        $module = $module->where('mod_alias',$alias)->get();

        if ($module->isEmpty())
        {
            /*
            * if module not found
            */
            return null;
        }

        $module = $module->first();

        if($module->parent_id !== 0)
        {
            $parent_module = Repository()->get_admin_module()->where('modid',$module->parent_id)->first();
            $icon           = isset($parent_module->mod_icon) && $icon ? "<i class=\"$parent_module->mod_icon\"></i>" : null;
        }
        else
        {
            $icon = $icon ? "<i class=\"$module->mod_icon\"></i>" : "";
        }

        $name = match ($role) {
            'create' => 'Add '.$module->mod_name,
            'update' => 'Edit ' . $module->mod_name,
            'delete' => 'Delete ' . $module->mod_name,
            default => $module->mod_name
        };

        return "$icon $name";
    }

    /**
     * generate breadcrumb
     *
     * @param string $alias
     * @param string $role
     * @return string|null
     */
    public function generate_breadcrumb(string $alias = "",string $role = "read")
    {
        /*
        * define variable
        */
        $module = Repository()->get_admin_module();
        $parent = "<ol class=\"breadcrumb\">";

        /*
        * find module
        */
        $module = $module->where('mod_alias',$alias)->get();

        if ($module->isEmpty())
        {
            /*
            * if module not found
            */
            return null;
        }

        $module = $module->first();

        if($module->parent_id != 0)
        {
            $parent_module  = Repository()->get_admin_module()->where('modid',$module->parent_id)->first();
            $icon           = isset($parent_module->mod_icon) ? "<i class=\"$parent_module->mod_icon\"></i>" : null;
            $item           = "<li>$icon $parent_module->mod_name</li>";
            $item           .= "<li>$module->mod_name</li>";
        }
        else
        {
            $item = "<li><i class=\"$module->mod_icon\"></i> $module->mod_name</li>";
        }

        $item .= match ($role) {
            'create' => "<li>Add $module->mod_name</li>",
            'update' => "<li>Edit $module->mod_name</li>",
            'delete' => "<li>Detele $module->mod_name</li>",
            default => "",
        };

        return $parent.$item."</ol>";
    }

    /**
     * get role mode user
     *
     * @param string $role
     * @return array
     */
    public function role_module(string $role = 'read')
    {
        /*
        * define variable
        */
        $module     = Repository()->get_admin_module();
        $data_user  = general()->user_active();
        $role_mod   = array();

        if($data_user)
        {
            $roles      = $data_user->role;

            $role = match ($role) {
                'create' => $roles->create[0] == '*' ? $module->pluck('modid')->toArray() : $roles->create,
                'update' => $roles->update[0] == '*' ? $module->pluck('modid')->toArray() : $roles->update,
                'delete' => $roles->delete[0] == '*' ? $module->pluck('modid')->toArray() : $roles->delete,
                'read' => $roles->read[0] == '*' ? $module->pluck('modid')->toArray() : $roles->read,
                default => []
            };

            $get_modules = $module->whereIn('modid',$role)->where('published','=','y');

            foreach($get_modules->get() as $val)
            {
                $role_mod[$val->modid] = $val->mod_alias;
            }
        }

        return $role_mod;
    }

    /**
     * check mod access
     *
     * @param string $alias
     * @param string $role
     * @return bool
     */
    public function module_access(string $alias = '', string $role = 'read')
    {
        $access = FALSE;
        $role_mod = $this->role_module($role);

        if(is_array($role_mod) && in_array($alias, $role_mod))
        {
            $access = TRUE;
        }

        return $access;
    }

}