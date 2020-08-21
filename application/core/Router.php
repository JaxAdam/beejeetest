<?php


namespace application\core;

use application\core\lib\Db;

class Router
{
    private $routes = [];
    private $parameters = [];

    public function __construct()
    {
        $db = new Db();
        $routesFromDb = $db->getAll("SELECT * FROM `routes`");
        foreach ($routesFromDb as $route) {
            $this->addRoute($route['route'], $route['controller'], $route['action']);
        }
    }

    public function addRoute($route, $controller, $action)
    {
        $route = preg_replace('/{([a-z\-]+):([^\}\-]+)}/', '(?<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = [
            'controller' => $controller,
            'action' => $action,
        ];
    }

    public function matchRoute()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $parameters) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int)$match;
                        }
                        $parameters[$key] = $match;
                    }
                }
                $this->parameters = $parameters;
                return true;
            }
        }
        return false;
    }

    public function runApplication()
    {
        if ($this->matchRoute()) {
            if(!empty($_SESSION)){
                $this->loadSessionParameters();
            }
            $controllerPath = 'application\controllers\\' . ucfirst($this->parameters['controller']) . 'Controller';
            if (class_exists($controllerPath)) {
                $action = $this->parameters['action'] . 'Action';
                if (method_exists($controllerPath, $action)) {
                    $controllerObject = new $controllerPath($this->parameters);
                    $controllerObject->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

    public function loadSessionParameters(){
        foreach ($_SESSION as $key => $value){
            $this->parameters[$key] = $value;
        }
    }


}