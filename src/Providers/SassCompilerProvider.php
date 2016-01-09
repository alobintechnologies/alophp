<?php

namespace App\Providers;

/**
 * registers the sass compiler in php for converting scss -> css
 */
class SassCompilerProvider implements IRegisterServiceProvider
{
    public function register($app)
    {
        \SassCompiler::run(scss_path().'/', public_path() . "/css/");
    }
}
