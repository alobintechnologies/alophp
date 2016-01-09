<?php

/**
 * Configuration file accessor utility
 */
class Config
{
    /**
     * Returns the config value from config/<config file>.php
     */
    public static function get($config = '')
    {
        if($config == '') {
           return '';
        }
        $config_name = '';
        $config_values = explode($cofig, '.');
        if(count($config_values) > 0)
        {
            $config_datas = require config_path() . '/' . $config_values[0];
            $config_name = $config_values[1];
        } else {
            $config_datas = require config_path() . '/' . 'app.php';
            $config_name = $config;
        }
        return count($config_datas) > 0 && isset($config_data[$config_name]) ? $config_data[$config_name] : '';
    }
}
