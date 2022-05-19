<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /* set default mod Alias */
        $this->middleware(function ($request, $next) {
            $this->viewdata['mod_alias'] = 'dashboard';
            return $next($request);
        });
    }

    /**
     * dashboard page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        /*
         * set view data
         */
        $this->viewdata['page_tittle'] = modules()->generate_title('dashboard');
        return view('home::index',$this->viewdata);
    }
}
