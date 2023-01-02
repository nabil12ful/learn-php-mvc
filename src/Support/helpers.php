<?php

if(!function_exists('env'))
{
    function env($key, $default = null)
    {
        return $_ENV[$key] ?? value($default);
    }
}

if(!function_exists('value'))
{
    function value($value)
    {
        return ($value instanceof Closure) ? $value() : $value;
    }
}

if (!function_exists('config_path')) 
{
    function config_path()
    {
        return base_path() . 'config/';
    }
}

if (!function_exists('config')) 
{
    function config($key = null, $default = null)
    {
        if(is_null($key))
        {
            return app()->config;
        }
        if(is_array($key))
        {
            return app()->config->set($key);
        }
        return app()->config->get($key, $default);
    }
}

if(!function_exists('app'))
{
    function app()
    {
        static $instance = null;

        if(!$instance)
        {
            $instance = new \Nopel\App;
        }

        return $instance;
    }
}

if(!function_exists('base_path'))
{
    function base_path($path = '')
    {
        if(strlen($path) > 0)
        {
            return dirname(__DIR__) . '/../' . $path;
        }else{
            return dirname(__DIR__) . '/../';
        }
    }
}

if(!function_exists('view_path'))
{
    function view_path()
    {
        return base_path('Views/');
    }
}

if(!function_exists('view'))
{
    function view($view, $data = [])
    {
        return \Nopel\View\View::make($view, $data);
    }
}