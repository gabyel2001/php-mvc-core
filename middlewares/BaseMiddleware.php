<?php

namespace theworker\phpmvc\middlewares;

abstract class BaseMiddleware
{
    abstract public function execute();
}