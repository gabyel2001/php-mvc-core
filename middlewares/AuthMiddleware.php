<?php

namespace theworker\phpmvc\middlewares;

use theworker\phpmvc\Application;
use theworker\phpmvc\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 *
 * @category
 * @package theworker\phpmvc\middlewares
 * @author gabriel.berza
 */
class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }


    public function execute()
    {
        if(Application::isGuest()){
            if(empty($this->actions) ||
                in_array(Application::$app->controller->action, $this->actions)){
                throw new ForbiddenException();
            }
        }
    }
}