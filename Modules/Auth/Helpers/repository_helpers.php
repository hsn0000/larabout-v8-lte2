<?php
use Modules\Auth\Repositories\AuthRepository;

if  ( ! function_exists('AuthRepository'))
{
    /**
     * @return AuthRepository
     */
    function AuthRepository()
    {
        return new AuthRepository();
    }
}
