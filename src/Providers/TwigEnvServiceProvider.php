<?php

namespace App\Providers;

class TwigEnvServiceProvider implements IRegisterServiceProvider
{
    public function register($app)
    {
        $app->add('Twig_Environment')
            ->withArgument(new \Twig_Loader_Filesystem(views_path()));
    }
}
