<?php

namespace Shurjomukhi\ShurjopayPhpPlugin;

use Illuminate\Support\ServiceProvider;

/**
 * This is Shurjopay Service-Provider.It has two core methods named as register() & boot()
 * like other general service-provider.
 *
 * Inside register() method:-
        Shurjopay controller is registered.
        Merged package's custom config with applicatin config's directory.
 * Inside boot() method:-
        Package's custom configuration is published.
 *
 * @author Rayhan Khan Ridoy
 * @since 2022-12-01
*/

class ShurjopayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->make('Shurjomukhi\ShurjopayPhpPlugin\ShurjopayPlugin');
   
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      

      
    }

}