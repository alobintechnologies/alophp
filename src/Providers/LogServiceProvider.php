<?php

namespace App\Providers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * Log service provider
 */
class LogServiceProvider implements IRegisterServiceProvider
{
    public function register($app)
    {
        // Create the logger
        $logger = new Logger(Config::get('log.log_name'));
        // Now add some handlers
        $logger->pushHandler(new StreamHandler(Config::get('log.log_file'), Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());

        $app->add('logger', $logger);
    }
}
