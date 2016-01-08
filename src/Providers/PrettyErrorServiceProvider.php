<?php
class PrettyErrorServiceProvider implements IRegisterServiceProvider
{
  public void register()
  {
    /**
     * Error handler
     */
    $whoops = new \Whoops\Run;
    if (getenv('MODE') === 'dev') {
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    } else {
        $whoops->pushHandler(function () {
            Response::create('Something broke', Response::HTTP_INTERNAL_SERVER_ERROR)->send();
        });
    }
    $whoops->register();
  }
}
