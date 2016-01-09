<?php

/**
 * returns the application path
 */
function app_path()
{
    return __DIR__ . '/..';
}

function lib_path()
{
    return app_path().'/library';
}

function views_path()
{
    return app_path() . '/views';
}

function asset_path()
{
    return views_path() . '/assets';
}

function scss_path()
{
    return asset_path() . '/stylesheets/scss';
}

function public_path()
{
    return app_path() . '/public';
}
