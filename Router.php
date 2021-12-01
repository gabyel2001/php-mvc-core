<?php

namespace app\core;

use app\core\exception\NotFoundException;

/**
 * Class Router
 *
 * @category
 * @package app\core
 * @author gabriel.berza
 */
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];


    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, string|\Closure|array $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if(is_array($callback)){
            /**
             * @var \app\core\Controller $controller
             */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);

    }

    public function post(string $path, string|\Closure|array $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

}