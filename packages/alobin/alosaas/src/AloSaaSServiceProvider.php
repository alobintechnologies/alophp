<?php

namespace Alobin\AloSaaS;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class AloSaaSServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->handleConfigs();
		
		$this->handleTranslations();
		
		$this->setupRoutes ( $this->app->router );
		
		
		$this->handleMigrations();
		$this->handleViews();
	}
	
	/**
	 * Define the routes for the application.
	 *
	 * @param \Illuminate\Routing\Router $router        	
	 * @return void
	 */
	public function setupRoutes(Router $router) {
		$router->group ( [ 
				'namespace' => 'Alobin\AloSaaS\Http\Controllers' 
		], function ($router) {
			require __DIR__ . '/Http/routes.php';
		} );
	}
	
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		config ( [ 
				'config/alosaas.php' 
		] );
	}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return [ ];
	}
	
	private function handleConfigs() {
		$configPath = __DIR__ . '/../config/alosaas.php';
		$this->publishes ( [ 
				$configPath => config_path ( 'alosaas.php' ) 
		] );
		$this->mergeConfigFrom ( $configPath, 'alosaas' );
	}
	
	private function handleTranslations() {
		$this->loadTranslationsFrom ( 'alosaas', __DIR__ . '/../lang' );
	}
	
	private function handleViews() {
		$this->loadViewsFrom ( 'alosaas', __DIR__ . '/../views' );
		$this->publishes ( [ 
				__DIR__ . '/../views' => base_path ( 'resources/views/vendor/alosaas' ) 
		] );
	}
	
	private function handleMigrations() {
		$this->publishes ( [ 
				__DIR__ . '/../migrations' => base_path ( 'database/migrations' ) 
		] );
	}
}
