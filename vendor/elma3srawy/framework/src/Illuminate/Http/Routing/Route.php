<?php 
namespace Illuminate\Http\Routing;


use Illuminate\Http\Routing\Router;


class Route extends Router
{
    public static function get(string $uri , callable|string|array $action)
    {
        parent::add('get' , $uri , $action);
    }
    public static function post(string $uri , callable|string|array $action)
    {
        parent::add('post' , $uri , $action);
    }
}