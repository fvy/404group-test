<?php

namespace Fvy\Group404\Components;


class Router
{
    private $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        return false;
    }

    public function run()
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            if ($this->isMatchedControllerName($uriPattern, $uri)) {

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);

                $controllerName = $this->getControllerName($segments);
                $actionName = $this->getActionName($segments);
                $controllerFile = $this->getControllerFile($controllerName);

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $controllerNameWithPath = 'Fvy\\Group404\\Controllers\\' . $controllerName;
                $controllerObject = new $controllerNameWithPath();

                // $result = $controllerObject->$actionName($parameters);
                // $result = call_user_func(array($controllerObject, $actionName), $parameters);
                try {
                    $result = call_user_func_array(array($controllerObject, $actionName), $segments);
                    if ($result !== null) {
                        break;
                    }
                } catch (\Exception $exception) {
                    print_r("<pre>");
                    print_r("<br>Error msg: " . $exception->getMessage());
                    print_r("<br>Error file: " . $exception->getFile());
                    print_r("<br>Error line: " . $exception->getLine());
                    print_r("</pre>");

                    print_r("<pre style='background-color: black; color: limegreen;'>");
                    print_r($exception->getTraceAsString());
                    print_r("</pre>");
                }
            }
        }
    }

    function isMatchedControllerName($uriPattern, $uri)
    {
        return preg_match("~$uriPattern~", $uri);
    }

    function getControllerName(&$segments) {

        return ucfirst(array_shift($segments) . 'Controller');
    }

    private function getActionName(&$segments)
    {
        return 'action' . ucfirst(array_shift($segments));
    }

    private function getControllerFile($controllerName)
    {
        return ROOT . '/src/Controllers/' . $controllerName . '.php';
    }
}