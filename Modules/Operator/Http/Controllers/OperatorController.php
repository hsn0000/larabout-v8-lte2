<?php

namespace Modules\Operator\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OperatorController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /* set default mod Alias */
        $this->middleware(function ($request, $next) {
            $this->viewdata['mod_alias'] = 'operator';
            return $next($request);
        });
    }

    /**
     * operator page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        /*
         * get all GET data
         */
        $all_get = (object)$request->all();

        if($request->ajax())
        {
            /*
             * getting data for data table
             */
            /*
             * if ajax request
             */
            $data = OperatorRepository()->get_operator_table();
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    /*
                     * for custom filtering data
                     */

                    /*
                     * get all POST data
                     */
                    $all_post = (object)$request->all();

                    if(isset($all_post->active))
                    {
                        $query->where('admin.active', $all_post->active);
                    }

                    if(isset($all_post->guid))
                    {
                        $query->where('admin.guid', $all_post->guid);
                    }

                    if(isset($all_post->q))
                    {
                        $search = $all_post->q;

                        $query->where(function($q) use ($search){
                            $q->where('admin.aid', '=', "$search");
                            $q->orWhere('admin.fullname', 'like', "%$search%");
                            $q->orWhere('admin.username', 'like', "%$search%");
                            $q->orWhere('admin_groups.name', 'like', "%$search%");
                        });
                    }
                })
                ->addColumn('active', function($data){

                    if(module_access('operator','update'))
                    {
                        $user_active = user_active();
                        $active = $data->active == 'y' ? 'checked' : '';
                        $disabled = $user_active->aid == $data->aid ? 'disabled' : '';

                        return "<div class=\"mt-ios fs-6 p-t-4 p-b-4 active-operator\"><input id=\"active-$data->aid\" type=\"checkbox\" name=\"active\" $active $disabled class='active-operator-checkbox' data-id='$data->aid'/><label for=\"active-$data->aid\"></label></div>";
                    }
                    else
                    {
                        return active($data->active);
                    }
                })
                ->addColumn('action', function($data){

                    $user_active = user_active();
                    $btn = '';

                    if($user_active->aid == $data->aid)
                    {
                        if(module_access('operator','update'))
                        {
                            $btn .= "<button class=\"btn btn-sm btn-default disabled\" data-id='$data->aid'><i class=\"fa fa-pencil\"></i></button> &nbsp;";
                        }

                        if(module_access('operator','delete'))
                        {
                            $btn .= "<button class=\"btn btn-sm btn-default disabled\" data-id='$data->aid'><i class=\"fa fa-trash\"></i></button>";
                        }
                    }
                    else
                    {
                        if(module_access('operator','update'))
                        {
                            $btn .= "<button class=\"btn btn-sm btn-default btn-edit\" data-id='$data->aid'><i class=\"fa fa-pencil\"></i></button> &nbsp;";
                        }

                        if(module_access('operator','delete'))
                        {
                            $btn .= "<button class=\"btn btn-sm btn-default btn-delete\" data-id='$data->aid'><i class=\"fa fa-trash\"></i></button>";
                        }
                    }

                    if(!module_access('operator','update') && !module_access('operator','delete'))
                    {
                        $btn .= "No Action!";
                    }

                    return $btn;
                })
                ->rawColumns(['active','action'])
                ->make(true);
        }

        /*
         * set view data
         */
        $this->viewdata['all_get'] = $all_get;
        $this->viewdata['dropdown_operator_group'] = OperatorGroupRepository()->get_dropdown_operator_group();
        $this->viewdata['page_tittle'] = modules()->generate_title('operator');
        return view('operator::index',$this->viewdata);
    }

    /**
     * show modal add operator
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add()
    {
        /*
         * set view data
         */
        $this->viewdata['dropdown_operator_group'] = OperatorGroupRepository()->get_dropdown_operator_group();

        /*
         * get form view
         */
        $form = view('operator::form_add',$this->viewdata)->render();

        $return = [
            'success' => true,
            'data' => [
                'title' => modules()->generate_title('operator','create'),
                'form' => $form
            ],
        ];

        return response()->json($return);
    }

        /**
     * process save operator
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
            'guid' => 'required',
            'username' => 'required',
            'fullname' => 'required',
            'password' => 'required|max:50|min:6',
            'repassword' => 'required_with:password|same:password|max:50|min:6',
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */

            $all_post->username = strtolower($all_post->username);

            /*
             * check username exist or not
             */
            $username_exist = OperatorRepository()->username_exist($all_post->username);

            if (!!$username_exist)
            {
                session()->flash('msg_error','Ca\'t Create Data ! Username Already Exist');
                return redirect()->route('operator');
            }

            if ($all_post->guid === 0)
            {
                session()->flash('msg_error','Ca\'t Create Data ! Please Select Admin Group field');
                return redirect()->route('operator');
            }

            /*
             * set insert data
             */
            $insert_data = [
                'guid'      => $all_post->guid,
                'username'  => $all_post->username,
                'fullname'  => $all_post->fullname,
                'password'  => aes_encrypt($all_post->password),
                'pin'       => '',
                'active'    => isset($all_post->active) && $all_post->active == 'on' ? 'y' : 'n',
            ];

            OperatorRepository()->insert_operator($insert_data);

            session()->flash('msg_success', 'Operator Created Successfully !');
        }
        else
        {
            /*
             * if validation failed
             */
            session()->flash('msg_error', $validator->errors()->first());
        }

        return redirect()->route('operator');
    }

    /**
     * show modal add operator
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        /*
         * get data edited operator
         */
        $operator = OperatorRepository()->get_operator('aid',$id)->get();


        if($operator->isEmpty())
        {
            $return = [
                'success' => false,
                'error' => [
                    'message' => 'Edited Operator Not Found!'
                ]
            ];
            return response()->json($return,404);
        }

        /*
         * set view data
         */
        $this->viewdata['operator'] = $operator->first();
        $this->viewdata['dropdown_operator_group'] = OperatorGroupRepository()->get_dropdown_operator_group();

        /*
         * get form view
         */
        $form = view('operator::form_edit',$this->viewdata)->render();

        $return = [
            'success' => true,
            'data' => [
                'tittle' => modules()->generate_title('operator','update'),
                'form' => $form,
            ]
        ];

        return response()->json($return);

    }

    /**
     * update data operator
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
            'aid' => 'required',
            'guid' => 'required',
            'fullname' => 'required'
        );

        if (isset($all_post->password))
        {
            $rules['password'] = 'required|max:50|min:6';
            $rules['repassword'] = 'required_with:password|same:password|max:50|min:6';
        }

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */

            /*
             * get data edited operator
             */
            $operator = OperatorRepository()->get_operator()->where('aid','=',$all_post->aid)->get();

            if($operator->isEmpty())
            {
                session()->flash('Edited Operator Not Found!');
                return redirect(route('operator'));
            }

            /*
             * set update data
             */
            $update_data = [
                'guid'      => $all_post->guid,
                'fullname'  => $all_post->fullname,
                'active'    => isset($all_post->active) && $all_post->active == 'on' ? 'y' : 'n',
            ];

            /*
             * if password change
             */
            if(isset($all_post->password))
            {
                $update_data['password'] = aes_encrypt($all_post->password);
            }

            OperatorRepository()->update_operator($all_post->aid,$update_data);

            session()->flash('msg_success', 'Operator Successfully Updated!');
        }
        else
        {
            /*
             * if validation failed
             */
            session()->flash('msg_error', $validator->errors()->first());
        }

        return redirect(route('operator'));
    }

    /**
     * delete operator
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        /*
         * get data edited operator
         */
        $operator = OperatorRepository()->get_operator('aid',$id)->get();

        if($operator->isEmpty())
        {
            $return = [
                'success' => false,
                'error' => [
                    'message' => 'Edited Operator Not Found!'
                ]
            ];

            return response()->json($return,404);
        }

        OperatorRepository()->delete_operator($id);

        $return = [
            'success' => true,
            'data' => [
                'message' => 'Operator Successfully Deleted !'
            ]
        ];

        return response()->json($return);
    }

    /**
     * update active status operator
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update_active(Request $request)
    {
        /*
         * get all POST data
         */
        $all_post = (object)$request->all();

        /*
        * set form validation
        */
        $rules = array(
            'aid' => 'required',
            'active' => 'required'
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */
            OperatorRepository()->update_operator($all_post->aid,['active'=>$all_post->active]);

            // Repository()->reset_cache_redis('modules');
            $return = [
                'success' => true,
                'data' => [
                    'message' => 'Operator Updated Successfully !'
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
