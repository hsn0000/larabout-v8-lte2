<?php

namespace Modules\Modules\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModulesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /* set default mod Alias */
        $this->middleware(function ($request, $next) {
            $this->viewdata['mod_alias'] = 'modules';
            return $next($request);
        });
    }

    /**
     * modules page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        /*
        * get list modules
        */ 
        $modules = Modules()->get_module(all_data:true);
        /*
         * set view data
         */
        $this->viewdata['modules'] = $modules;
        $this->viewdata['page_title'] = modules()->generate_title('modules');
        return view('modules::index',$this->viewdata);
    }

    /**
    * show modal add modules
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function add()
    {
        /*
         * set view data
         */
        $this->viewdata['dropdown_parent'] = ModulesRepository()->get_dropdown_parent_module();
        $this->viewdata['dropdown_icon'] = ModulesRepository()->get_dropdown_icon_module();

        /*
         * get form view
         */
        $form = view('modules::form_add',$this->viewdata)->render();

        $return = [
            'success' => true,
            'data' => [
                'title' => modules()->generate_title('modules','create'),
                'form' => $form,
            ]
        ];

        return response()->json($return);
    }

    /**
     * save data module
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function save(Request $request)
    {
        /*
         * get all POST data
         */
        $all_post = (object)$request->all();

        /*
         * set form validation
         */
        $rules = array(
            'parent' => 'required',
            'name' => 'required',
            'icon' => 'required',
            'alias' => 'required',
            'permalink' => 'required'
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */

            /*
             * define variable
             */
            $modules = Repository()->get_admin_module()->get();
            $check_module_exist = $modules->where('mod_alias','=',$all_post->alias)->isNotEmpty();

            if($check_module_exist)
            {
                session()->flash('msg_error','Ca\'t Create Data ! Modules Already Exist');
                return redirect(route('modules'));
            }

            if($all_post->parent === 0)
            {
                $module_count = $modules->where('parent_id','=','0')->count();
            }
            else
            {
                $module_count = $modules->where('parent_id','=',$all_post->parent)->count();
            }

            /*
             * set insert data
             */
            $insert_data = [
                'parent_id'     => $all_post->parent,
                'mod_name'      => $all_post->name,
                'mod_alias'     => $all_post->alias,
                'mod_icon'      => $all_post->icon == 0 ? null : 'fa '.$all_post->icon,
                'mod_order'     => $module_count,
                'permalink'     => $all_post->permalink ?? null,
                'published'     => isset($all_post->published) && $all_post->published == 'on' ? 'y' : 'n',
            ];

            ModulesRepository()->insert_module($insert_data);

            // Repository()->reset_cache_redis('modules');

            session()->flash('msg_success', 'Module Created Successfully !');
        }
        else
        {
            /*
             * if validation failed
             */
            session()->flash('msg_error', $validator->errors()->first());
        }

        return redirect(route('modules'));
    }

    /**
     * show modal edit modules
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        /*
         * get data edited module
         */
        $module = Repository()->get_admin_module()->where('modid','=',$id)->get();

        if($module->isEmpty())
        {
            /*
            * if data not found
            */ 
            $return = [
                'success' => false,
                'error' => [
                    'message' => 'Edited Module Not Found!'
                ]
            ];
            return response()->json($return,404);
        }
        /*
         * set view data
         */
        $this->viewdata['module'] = $module->first();
        $this->viewdata['dropdown_parent'] = ModulesRepository()->get_dropdown_parent_module();
        $this->viewdata['dropdown_icon'] = ModulesRepository()->get_dropdown_icon_module();
        /*
         * get form view
         */
        $form = view('modules::form_edit',$this->viewdata)->render();

        $return = [
            'success' => true,
            'data' => [
                'title' => modules()->generate_title('modules','update'),
                'form' => $form,
            ]
        ];

        return response()->json($return);
    }

    /**
     * update data module
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(Request $request)
    {
        /*
         * get all POST data
         */
        $all_post = (object)$request->all();

        /*
         * set form validation
         */
        $rules = array(
            'modid' => 'required',
            'parent' => 'required',
            'name' => 'required',
            'icon' => 'required',
            'alias' => 'required',
            'permalink' => 'required'
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */

            /*
             * get data edited module
             */
            $module = Repository()->get_admin_module()->where('modid','=',$all_post->modid)->get();

            if($module->isEmpty())
            {
                /*
                * if data not found
                */ 
                session()->flash('Edited Module Not Found!');
                return redirect(route('modules'));
            }

            $module = $module->first();

            /*
             * define variable
             */
            $existing_modules = Repository()->get_admin_module()
                ->where('mod_alias','=',$all_post->alias)
                ->where('mod_alias','!=',$module->mod_alias)
                ->get();

            if($existing_modules->isNotEmpty())
            {
                /*
                * if data already exist
                */ 
                session()->flash('msg_error','Ca\'t Create Data ! Modules Already Exist');
                return redirect(route('modules'));
            }

            /*
             * set update data
             */
            $update_data = [
                'parent_id'     => $all_post->parent,
                'mod_name'      => $all_post->name,
                'mod_alias'     => $all_post->alias,
                'mod_icon'      => $all_post->icon == 0 ? null : 'fa '.$all_post->icon,
                'permalink'     => $all_post->permalink ?? null,
                'published'     => isset($all_post->published) && $all_post->published == 'on' ? 'y' : 'n',
            ];

            ModulesRepository()->update_module($all_post->modid,$update_data);

            // Repository()->reset_cache_redis('modules');

            session()->flash('msg_success', 'Module Updated Successfully !');
        }
        else
        {
            /*
             * if validation failed
             */
            session()->flash('msg_error', $validator->errors()->first());
        }

        return redirect(route('modules'));
    }

    /**
     * update published status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update_published(Request $request)
    {
        /*
         * get all POST data
         */
        $all_post = (object) $request->all();

        /*
         * set form validation
         */
        $rules = array(
            'modid' => 'required',
            'published' => 'required'
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */
            ModulesRepository()->update_module($all_post->modid,['published'=>$all_post->published]);

            // Repository()->reset_cache_redis('modules');
            $return = [
                'success' => true,
                'data' => [
                    'message' => 'Module Updated Successfully !',
                ]
            ];

            return response()->json($return);
        }
        else
        {
            /*
            * if validation failed
            */
            $return = [
                'success' => false,
                'error' => [
                    'message' => 'Invalid Update Data! Please Check The Parameter Before Update The Data.',
                ]
            ];

            return response()->json($return,401);

        }
    }

    /**
     * update order sort
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update_order(Request $request)
    {
        /*
         * get all POST data
         */
        $all_post = (object)$request->all();

        /*
         * set form validation
         */
        $rules = array(
            'parent' => 'required',
            'child' => 'required'
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */

            if($all_post->parent)
            {
                foreach ($all_post->parent as $key => $parent_id)
                {
                    ModulesRepository()->update_module($parent_id,['mod_order'=>$key]);
                }
            }

            if($all_post->child)
            {
                foreach ($all_post->child as $parent)
                {
                    foreach ($parent as $key => $parent_id)
                    {
                        ModulesRepository()->update_module($parent_id,['mod_order'=>$key]);
                    }
                }
            }

            // Repository()->reset_cache_redis('modules');
            $return = [
                'success' => true,
                'data' => [
                    'message' => 'Module Updated Successfully !'
                ]
            ];

            return response()->json($return);
        }
        else
        {
            /*
             * if validation failed
             */
            $return = [
                'success' => false,
                'error' => [
                    'message' => 'Invalid Update Data! Please Check The Parameter Before Update The Data.'
                ]
            ];

            return response()->json($return,401);

        }
    }

}
