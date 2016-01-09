<?php
namespace App\Providers;

class AppServiceProvider implements IRegisterServiceProvider
{
  /**
   * Register all the dependencies for this application
   */
  public function register($app)
  {
      define('GLOABAL_VIEWS_PATH', __DIR__.'/../views');
  }

}
