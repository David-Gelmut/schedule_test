<?php

namespace src;
class Router
{
    protected array $routes;
    protected Request $request;
    public function __construct()
    {
        $this->request = new Request();
        $this->routes = include ROOT . '/routes/web.php';
    }

    public function run()
    {
        foreach ($this->routes as $uriPattern => $path) {
            if ($uriPattern == $this->request->getURI()) {
                $segments = explode('/', $path);
                $controllerName = ucfirst($segments[0]) . 'Controller';
                $actionName = $segments[1];
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    require_once($controllerFile);
                    $controllerObject = '\controllers\\' . $controllerName;
                    $controllerObject = new $controllerObject;;
                    $parameters = [];
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                    if ($result) {
                       return;
                    }
                }
            }
        }
    }
}