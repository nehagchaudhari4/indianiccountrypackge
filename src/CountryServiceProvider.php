<?php
namespace Indianiic\Country;

use Illuminate\Support\ServiceProvider;

class CountryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */


     public function register(){
        $this->app->make('Indianiic\Country\Controllers\CountryController');
     }
	/**
     * Bootstrap services.
     *
     * @return void
     */
	 public function boot(){
	 	$this->loadRoutesFrom(__DIR__.'routes/web.php');

      $this->loadViewsFrom(__DIR__.'views', 'country');

      $this->loadMigrationsFrom(__DIR__.'migrations','country');

       
        //config
        $this->publishes([
            __DIR__.'config/country.php' => config_path('country.php')
        ], 'config');

	 }

}