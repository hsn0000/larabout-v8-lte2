<?php

namespace App\Http\Controllers;

use App\Library\General;
use App\Repositories\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected Repository $repository;

    protected General $general;

    protected array $viewdata;

    protected int $limit = 50;

    public function __construct()
    {
        $this->general = general();
        $this->repository = new Repository();
        /*
         * init variable for controller
         */
        $this->middleware(function ($request, $next) {
            $this->viewdata = general()->viewdata();
            return $next($request);
        });
    }
}
