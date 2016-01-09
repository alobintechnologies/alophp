<?php

namespace App\Providers;

/**
 * Database service registration
 */
class DatabaseServiceProvider implements IRegisterServiceProvider
{
    public function register($app)
    {
        $app->add('PDO')
            ->withArgument(getenv('DB_CONN'))
            ->withArgument(getenv('DB_USER'))
            ->withArgument(getenv('DB_PASS'));
    }
}
 ?>
