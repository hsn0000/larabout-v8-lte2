<?php

use Modules\OperatorGroup\Repositories\OperatorGroupRepository;

if  ( ! function_exists('OperatorGroupRepository'))
{
    /**
     * @return OperatorGroupRepository
     */
    function OperatorGroupRepository()
    {
        return new OperatorGroupRepository();
    }
}
