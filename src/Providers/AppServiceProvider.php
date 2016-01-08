<?php
class AppServiceProvider implements IRegisterServiceProvider
{
  /**
   * Register all the dependencies for this application
   */
  public void register()
  {
    define('GLOABAL_VIEWS_PATH', __DIR__.'/../views');
  }

}
