<?php

namespace Modules\OperatorGroup\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OperatorGroupController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /* set default mod Alias */
        $this->middleware(function ($request, $next) {
            $this->viewdata['mod_alias'] = 'operator-group';
            return $next($request);
        });
    }

    /**
     * operator group page
     *
     * @param Request $request
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
            $data = OperatorGroupRepository()->get_operator_group_table();
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

                    if(isset($all_post->q))
                    {
                        $search = $all_post->q;
                        $query->where(function($q) use ($search){
                            $q->where('admin_groups.name', 'like', "%$search%");
                        });

                    }
                })
                ->addColumn('read', function($data){
                    $read = json_decode($data->read);

                    return isset($read[0]) ? ($read[0] == '*' ? 'All' : count($read)) : '0';
                })
                ->addColumn('create', function($data){
                    $create = json_decode($data->create);

                    return isset($create[0]) ? ($create[0] == '*' ? 'All' : count($create)) : '0';
                })
                ->addColumn('update', function($data){
                    $update = json_decode($data->update);

                    return isset($update[0]) ? ($update[0] == '*' ? 'All' : count($update)) : '0';
                })
                ->addColumn('delete', function($data){
                    $delete = json_decode($data->delete);

                    return isset($delete[0]) ? ($delete[0] == '*' ? 'All' : count($delete)) : '0';
                })
                ->addColumn('action', function($data){

                    $btn = '';

                    if(module_access('operator-group','update'))
                    {
                        $btn .= "<button class=\"btn btn-sm btn-default btn-edit\" data-id='$data->guid'><i class=\"fa fa-pencil\"></i></button> &nbsp;";
                    }

                    if(module_access('operator-group','delete'))
                    {
                        $btn .= "<button class=\"btn btn-sm btn-default btn-delete\" data-id='$data->guid'><i class=\"fa fa-trash\"></i></button>";
                    }

                    if(!module_access('operator-group','update') && !module_access('operator-group','delete'))
                    {
                        $btn .= "No Action!";
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        /*
        * set view data
        */
        $this->viewdata['all_get'] = $all_get;
        $this->viewdata['page_title'] = modules()->generate_title('operator-group');
        return view('operatorgroup::index',$this->viewdata);
    }

    /**
     * show modal add operator groups
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add()
    {
        /*
         * set view data
         */
        $this->viewdata['module'] = modules()->get_module();
        /*
         * get form view
         */
        $form = view('operatorgroup::form_add',$this->viewdata)->render();

        $return = [
            'success' => true,
            'data' => [
                'title' => modules()->generate_title('operator-group','create'),
                'form' => $form,
            ]
        ];

        return response()->json($return);
    }

    /**
     * process save operator group
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function save(Request $request)
    {
        /*
         * get all post data
         */
        $all_post = (object)$request->all();

        /*
         * set form validation
         */
        $rules = array(
            'name' => 'required',
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */

            /*
             * insert data operator group
             */
            $insert_data = array(
                "name"      => $all_post->name,
                "create"    => json_encode($all_post->create ?? []),
                "read"      => json_encode($all_post->read ?? []),
                "update"    => json_encode($all_post->update ?? []),
                "delete"    => json_encode($all_post->delete ?? [])
            );

            OperatorGroupRepository()->insert_operator_group($insert_data);

            session()->flash('msg_success', 'Data Saved!');
        }
        else
        {
            /*
             * if validation failed
             */
            session()->flash('msg_error', $validator->errors()->first());
        }

        return redirect()->route('operator-group');

    }

    /**
     * page edit operator group
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $operator_group = OperatorGroupRepository()->get_operator_group('guid',$id);

        if($operator_group->isEmpty())
        {
            return response_api('Invalid Data! Operator Group does\'t exist',404);
        }

        $operator_group = $operator_group->first();

        /*
         * set view data
         */
        $this->viewdata['operator_group'] = $operator_group;
        $this->viewdata['module'] = modules()->get_module();

        /*
         * get form view
         */
        $form = view('operatorgroup::form_edit',$this->viewdata)->render();

        $return = [
            'success' => true,
            'data' => [
                'title' => modules()->generate_title('operator-group','update'),
                'form' => $form,
            ]
        ];

        return response()->json($return);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(Request $request)
    {
        /*
         * get all POST data from request
         */
        $all_post = (object)$request->all();

        /*
         * set form validation
         */
        $rules = array(
            'guid' => 'required',
            'name' => 'required',
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */

            /*
             * check operator groups is existing or not
             */
            $operator_group = OperatorGroupRepository()->get_operator_group('guid',$all_post->guid);

            if ($operator_group->isEmpty())
            {
                session()->flash('msg_error', 'Data Not found!');
                return redirect()->route('operator-group');
            }

            /*
             * set update data
             */
            $update_data = array(
                "name"      => $all_post->name,
                "create"    => json_encode($all_post->create  ?? []),
                "read"      => json_encode($all_post->read ?? []),
                "update"    => json_encode($all_post->update ?? []),
                "delete"    => json_encode($all_post->delete ?? [])
            );

            $update = OperatorGroupRepository()->update_operator_group($all_post->guid,$update_data);

            if($update)
            {
                /*
                 * if update success
                 */

                /*
                 * reload privileges operator
                 */
                $operator = AuthRepository()->get_admin_login(user_active()->username);

                /*
                 * check user exist
                 */
                if ($operator->isNotEmpty())
                {
                    $operator = $operator->first();

                    /*
                     * set data session rule
                     */
                    $session_role['create']  = json_decode($operator->role_create);
                    $session_role['read']    = json_decode($operator->role_read);
                    $session_role['update']  = json_decode($operator->role_update);
                    $session_role['delete']  = json_decode($operator->role_delete);
                    /*
                     * set data session user
                     */
                    $session_user['aid']        = $operator->aid;
                    $session_user['username']   = $operator->username;
                    $session_user['fullname']   = $operator->fullname;
                    $session_user['guid']       = $operator->guid;
                    $session_user['userlevel']  = $operator->userlevel;
                    $session_user['role']       = (object)$session_role;

                    $session['user'] = (object)$session_user;

                    session()->put($session);
                }
            }

            session()->flash('msg_success','Operator Group Updated!');

        }
        else
        {
            /*
             * if validation failed
             */

            session()->flash('msg_error', $validator->errors()->first());
        }

        return redirect()->route('operator-group');
    }

    /**
     * delete operator groups
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $operator_group = OperatorGroupRepository()->get_operator_group('guid',$id);

        if($operator_group->isEmpty())
        {
            $return = [
                'success' => false,
                'data' => [
                    'message' => 'Invalid Data! Operator Group does\'t exist',
                ]
            ];

            return response()->json($return,400);
        }

        $operator = OperatorRepository()->get_operator('guid',$id)->get();

        if($operator->isNotEmpty())
        {
            $return = [
                'success' => false,
                'data' => [
                    'message' => 'Invalid Data! Operator Group Already Has Operator !',
                ]
            ];
            
            return response()->json($return,400);
        }

        OperatorGroupRepository()->delete_operator_group($id);

        $return = [
            'success' => true,
            'data' => [
                'message' => 'Operator Successfully Deleted !',
            ]
        ];
        
        return response()->json($return);
    }
}
