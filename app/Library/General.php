<?php
/**
 * Class General
 * @package App\Library
 */
namespace App\Library;

use Illuminate\Support\Carbon;

class General
{
    /**
     * @var string
     */
    public string $date;

    /**
     * @var string
     */
    public string $datetime;

    /**
     * @var object
     */
    public object $config;

    /**
     * General constructor.
     */
    public function __construct()
    {
        $this->datetime	    = Carbon::now();
        $this->date			= Carbon::now();

        $this->set_config();
    }

    /**
     * get view data
     *
     * @return array
     */
    public function viewdata()
    {
        /*
         * define variable
         */
        $self = new self();

        /*
         * init view data
         */
        return array(
            'general' => $self,
            'site_name' => $this->config->site_name,
            'user' => $this->user_active(),
        );
    }

    /**
     * get active user
     *
     * @return \App\Resolver\UserActiveResolve | false
     */
    public function user_active()
    {
        if (session()->has('user'))
        {
            return session('user');
        }
        else
        {
            return false;
        }
    }

    /**
     * generate flash data
     *
     * @return string|null
     */
    public function flash_message()
    {
        $msg = NULL;

        if (session()->has('msg_success'))
        {
            $msg = "<div class=\"alert alert-success alert-dismissible fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration: none'>&times;</a><strong>Success!</strong> ".session('msg_success')."</div>";
        }
        if (session()->has('msg_error'))
        {
            $msg = "<div class=\"alert alert-danger alert-dismissible fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration: none'>&times;</a> <strong>Danger!</strong> ".session('msg_error')."</div>";
        }
        if (session()->has('msg_info'))
        {
            $msg = "<div class=\"alert alert-info alert-dismissible fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration: none'>&times;</a><strong>Info!</strong> ".session('msg_info')."</div>";
        }
        if (session()->has('msg_warning'))
        {
            $msg = "<div class=\"alert alert-warning alert-dismissible fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" style='text-decoration: none'>&times;</a><strong>Warning!</strong> ".session('msg_warning')."</div>";
        }

        return $msg;
    }

    public function set_config()
    {
        $this->config = (object)[
            'brand_name' => 'Larabout',
            'site_name' => 'Larabout-lte-v8'
        ];
        return $this;
    }

}
