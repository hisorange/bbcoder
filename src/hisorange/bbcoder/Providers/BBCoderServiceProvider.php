<?php 
namespace hisorange\bbcoder\Providers;

use hisorange\bbcoder\BBCoder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class BBCoderServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot(){}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register the package.
		$this->package('hisorange/bbcoder', 'bbcoder');

		// Register package's config namespace.
        $this->app['config']->package('hisorange/bbcoder', dirname(dirname(dirname(__DIR__))).'/config');

		// Register 'bbcoder'.
		$this->app['bbcoder'] = $this->app->share(function ($app) {
			return new BBCoder($app['config']);
		});

		// Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias('BBCoder', 'hisorange\bbcoder\Facades\BBCoder');
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('bbcoder');
	}

}