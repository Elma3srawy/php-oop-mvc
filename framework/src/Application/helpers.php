<?php 

use Mvc\Application\App;


if (!function_exists("app")) 
{
    function app()
    {
        static $instance = null;
        if(!$instance)
        {
            $instance = new App;
        }
        return $instance;
    }
}

if (!function_exists("value")) 
{
    function value($value)
    {
        return ($value instanceof closure) ? call_user_func($value) : $value;
    }
}

if (!function_exists("base_path")) 
{
    function base_path($path = '')
    {
        $base = realpath(__DIR__ . '/../../../');
        return $path ? $base . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $base;
    }
}

if (!function_exists("env"))
{
    function env($key , $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists("config")) 
{
    function config($key = null , $value = null , $default= null)
    {
        if(is_null($key))
        {
            return app()->config;
        }
        if(is_array($key))
        {
            return app()->config->set($key);
        }

        return app()->config->get($key , $default);
    }
}
if (!function_exists('url')) 
{
    function url(string $path)
    {
        $path = $path[0] <> '/' ? '/' . $path : $path;
        return 'http://' . $_SERVER['HTTP_HOST'] . $path;
    }
}

if (!function_exists('redirect')) 
{
    ob_start();
    function redirect($url){
        
        $check_path = parse_url($url);

        if(isset($check_path['scheme']) && isset($check_path['host'])) {
            header('Location: ' . $url);
        } else {
            header('Location: ' . url($url));
        }
        exit();
    }

    ob_flush();
}

if (!function_exists('back')) 
{
    function back() 
    {
        if(isset($_SERVER['HTTP_REFERER'])){
            redirect ($_SERVER['HTTP_REFERER']);
        }
        
        redirect ('/');
    }
}
if (!function_exists('class_basename')) 
{
    function class_basename($class) 
    {
       $class = is_object($class) ? get_class($class) : $class;
       $class = explode('\\', $class);
       return end($class);
    }
}




