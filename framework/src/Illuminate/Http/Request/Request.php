<?php 

namespace Illuminate\Http\Request;


class Request
{
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function uri()
    {
       return $_SERVER['PATH_INFO'] ?? '/';
    }

    public function get($key = null)
    {
        return !$key ? $_GET : $_GET[$key] ?? null;
    }
    public function post($key = null)
    {
        return !$key ? $_POST : $_POST[$key] ?? null;
    }
    public function all($key = null)
    {
        return !$key ? $_REQUEST : $_REQUEST[$key] ?? null;
    }


}