<?php

use App\Library\General;
use App\Library\Modules;
use App\Repositories\Repository;
use App\Resolver\UserActiveResolve;

if  ( ! function_exists('Repository'))
{
    /**
     * @return Repository
     */
    function Repository()
    {
        return new Repository();
    }
}

if  ( ! function_exists('general'))
{
    /**
     * @return General
     */
    function general()
    {
        return new General();
    }
}

if  ( ! function_exists('modules'))
{
    /**
     * @return Modules
     */
    function modules()
    {
        return new Modules();
    }
}

if ( ! function_exists('user_active'))
{
    /**
     * get active user
     * @return UserActiveResolve|false
     */
    function user_active()
    {
        return general()->user_active();
    }
}

if ( ! function_exists('module_access'))
{
    function module_access($param,$role = 'read')
    {
        return modules()->module_access($param,$role);
    }
}
