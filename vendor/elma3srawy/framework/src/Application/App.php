<?php

namespace Mvc\Application;

use Illuminate\Databases\DB;
use Illuminate\Http\Routing\Router;
use Illuminate\Http\Request\Request;
use Illuminate\Support\Config\Config;
use Illuminate\Http\Response\Response;
use Illuminate\Support\Session\Session;
use Illuminate\Databases\Drivers\MysqlDatabase;


class App
{
    public $db;
    protected $request;
    protected $response;
    protected $route;
    protected $view;
    protected $session;
    public $config;


    public function __construct()
    {
        $this->connectWithDatabase();
        $this->db->init();
        $this->request = new Request;
        $this->response = new Response;
        $this->route = new Router($this->request , $this->response);
        $this->config = new Config($this->loadConfigurations());
    }

    public function run()
    {
        $this->route->dispatch();
    }

    protected function loadConfigurations()
    {
        $config_path = base_path('config');
        if (is_dir($config_path)) {
            $files = scandir($config_path);
            $files = array_diff($files, array('.', '..'));
            foreach($files as $file)
            {
                yield explode('.' ,$file )[0] => require $config_path . '\\' . $file;
            }
        }
    }

    protected function connectWithDatabase()
    {
        match (env('DB_CONNECTION')) {
            'mysql' => $this->db = new DB(new MysqlDatabase),
        };
    }
}
