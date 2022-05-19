<?php
use Modules\Modules\Repositories\ModulesRepository;

if  ( ! function_exists('ModulesRepository'))
{
    /**
     * @return ModulesRepository
     */
    function ModulesRepository()
    {
        return new ModulesRepository();
    }
}
