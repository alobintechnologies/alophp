<?php
class DotEnvServiceProvider implements IRegisterServiceProvider
{
  public void register()
  {
    // TODO: register dotenv code in here.

    /**
     * Dotenv setup
     */
    $dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->load();
  }
}
