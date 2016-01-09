<?php
namespace App\Providers;

class DotEnvServiceProvider implements IRegisterServiceProvider
{
  public function register($app)
  {
    // TODO: register dotenv code in here.

    /**
     * Dotenv setup
     */
    $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../');
    $dotenv->load();
  }
}
