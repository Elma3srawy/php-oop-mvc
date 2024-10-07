<?php 

namespace Illuminate\Http\Routing;

use Illuminate\Http\Request\Request;
use Illuminate\Http\Response\Response;


class Router
{
    protected static array $routes = [];

    protected Request $request;
    protected Response $response;

    public function __construct(Request $request , Response $response)
    {
        $this->request = $request ;
        $this->response = $response ;
    }
    protected static function add(string $method, string $uri , callable|string|array $action)
    {
        self::$routes[$method][self::segment($uri)] = $action;
    }

    private static function segment($uri)
    {
        return '/' . trim($uri , '/');
    }

    public function dispatch()
    {
        $uri = $this->request->uri();

        
        $method = $this->request->method();
        
        $routeInfo = $this->findMatchingRoute($uri, $method);
    
        if (!$routeInfo) {
            return $this->notFoundPage();
        }

        [$action, $params] = $routeInfo;

        if(!$action){
            return;
        }

        if(is_callable($action)){
            return $this->runCallableFunction($action , $params);
        }

        if(is_array($action)){
            return $this->RunMethod($action , $params);
        }
    }
    protected function runCallableFunction($action , $params)
    {
        call_user_func_array($action , $params);
    }

    private function notFoundPage()
    {
        var_dump("404 NOT FOUND");
        exit();
    }

    protected function RunMethod($action , $params){
        $class = $action[0];
        $method = $action[1];
        call_user_func_array([new $class , $method] , $params);
    }

    private function findMatchingRoute($uri, $method)
    {
        foreach (self::$routes[$method] ?? [] as $routePattern => $action) {
            $regex = $this->convertPatternToRegex($routePattern);
            if (preg_match($regex, $uri, $matches)) {
                array_shift($matches);
                return [$action, $matches];
            }
        }
        return null; 
    }
    
    private function convertPatternToRegex($pattern)
    {
        $escapedPattern = str_replace('/', '\/', $pattern);

        return '/^' . preg_replace('/\{([^\/]+)\}/', '([^\/]+)', $escapedPattern) . '$/';
    }
    


}

