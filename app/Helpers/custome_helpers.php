<?php

if( ! function_exists('id_transaction'))
{
    /**
     * @param int $number
     * @return string
     */
    function id_transaction(int $number)
    {
        return sprintf('%011d', $number);
    }
}

if( ! function_exists('uid'))
{
    /**
     * @param int $number
     * @return string
     */
    function uid(int $number)
    {
        return sprintf('%06d', $number);
    }
}