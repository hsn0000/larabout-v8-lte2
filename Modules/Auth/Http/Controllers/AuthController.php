<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * page login
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view('auth::login');
    }

    /**
     * process login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function do_login(Request $request)
    {
        /*
         * get all POST data
         */
        $all_post = (object)$request->all();

        /*
         * define variable
         */
        $callback = isset($all_post->redirect) ? rawurldecode($all_post->redirect) : '';
        $token = get_rand_alpha_numeric(15);

        /*
         * set form validation
         */
        $rules = array(
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        );

        $validator = validator();
        $validator = $validator->make($request->all(), $rules);

        if (!$validator->fails())
        {
            /*
             * if validation success
             */

            $user = AuthRepository()->get_admin_login($all_post->username);
            /*
             * check user exist
             */
            if ($user->isEmpty())
            {
                $return = [
                    'success_login'=> false,
                    'message' => 'User Not Found!'
                ];

                return response()->json(['data'=>$return]);
            }

            $user = $user->first();

            /*
             * check user active
             */
            if($user->active !== 'y')
            {
                $return = [
                    'success_login'=> false,
                    'message' => 'User blocked by system! please contact admin'
                ];

                return response()->json(['data'=>$return]);
            }

            /*
             * check user password
             */
            if ($all_post->password !== aes_decrypt($user->password))
            {
                $return = [
                    'success_login'=> false,
                    'message' => 'The provided password is incorrect.'
                ];

                return response()->json(['data'=>$return]);
            }

            /*
             * if login success
             */
            /*
             * set data session rule
             */
            $session_role['create']  = json_decode($user->role_create);
            $session_role['read']    = json_decode($user->role_read);
            $session_role['update']  = json_decode($user->role_update);
            $session_role['delete']  = json_decode($user->role_delete);
            /*
             * set data session user
             */
            $session_user['aid']        = $user->aid;
            $session_user['username']   = $user->username;
            $session_user['fullname']   = $user->fullname;
            $session_user['guid']       = $user->guid;
            $session_user['userlevel']  = $user->userlevel;
            $session_user['role']       = (object)$session_role;

            /*
             * set session login
             */
            $session['logged_in'] = true;
            $session['token_login'] = $token;
            $session['user'] = (object)$session_user;

            session()->put($session);

            $return = [
                'success_login' => true,
                'message' => 'Anda Berhasil Login!',
                'callback' => $callback
            ];

            // AdminLogRepository()->insert_admin_log('login');
        }
        else
        {
            /*
             * if validation failed
             */
            if ($validator->errors()->first() == 'validation.captcha')
            {
                $msg = 'Invalid captcha!';
            }
            else
            {
                $msg = 'Please Insert All Required Field!';
            }

            $return = [
                'success_login'=> false,
                'message' => $msg
            ];

        }

        return response()->json(['data'=>$return]);
    }

    /**
     * function to logout
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request) 
    {
        /*
        * destroy all session
        */ 
        // AdminLogRepository()->insert_admin_log('logout');
        session()->flush();
        session()->put('passcode',true);

        return redirect('');
    }
}
