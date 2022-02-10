<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

//        $config = array(
//            'app_id' => 1341378,
//            'app_key' =>  'f5c65542671ca7270b56',
//            'app_secret' => '1f144a054a29d97ced1e',
//            'app_cluster' => 'us2'
//        );
//        Config::set('pusher', $config);

        require base_path('routes/channels.php');
    }
}
