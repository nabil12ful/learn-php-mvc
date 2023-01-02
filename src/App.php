<?php

namespace Nopel;

use Nopel\Http\Request;
use Nopel\Http\Response;
use Nopel\Http\Route;
use Nopel\Support\Config;

class App
{
    protected Route $route;
    protected Request $request;
    protected Response $response;
    public Config $config;

    function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
        $this->route = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfigrations());
    }

    protected function loadConfigrations()
    {
        foreach(scandir(config_path()) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filename = explode('.', $file)[0];
            yield $filename => require config_path() . $file;
        }
    }

    public function run()
    {
        $this->route->resolve();
    }

    public function __get($name)
    {
        if(property_exists($this, $name))
        {
            return $this->name;
        }
    }
}