<?php

namespace theworker\phpmvc\middlewares;

/**
 * Class BaseMiddleware
 *
 * @category
 * @package theworker\phpmvc\middlewares
 * @author gabriel.berza
 */
abstract class BaseMiddleware
{
    abstract public function execute();
}