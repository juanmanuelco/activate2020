<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*
        $config = array(
            'driver'     => getConfiguration('text', 'MAIL_DRIVER' ),
            'host'       => getConfiguration('text', 'MAIL_HOST'),
            'port'       => intval(getConfiguration('text', 'MAIL_PORT')),
            'from'       => array('address' => getConfiguration('text', 'MAIL_USERNAME'), 'name' => getConfiguration('text', 'MAIL_FROM_NAME')),
            'encryption' => getConfiguration('text', 'MAIL_ENCRYPTION'),
            'username'   => getConfiguration('text', 'MAIL_USERNAME'),
            'password'   => getConfiguration('text', 'MAIL_PASSWORD'),
            'sendmail'   => '/usr/sbin/sendmail -bs',
            'pretend'    => false,
        );
        Config::set('mail', $config);
        */
    }
}
