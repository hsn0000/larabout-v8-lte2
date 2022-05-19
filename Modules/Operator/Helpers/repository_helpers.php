<?php

use Modules\Operator\Repositories\OperatorRepository;

if  ( ! function_exists('OperatorRepository'))
{
    /**
     * @return OperatorRepository
     */
    function OperatorRepository()
    {
        return new OperatorRepository();
    }
}
