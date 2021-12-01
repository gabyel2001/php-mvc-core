<?php

namespace theworker\phpmvc\exception;

/**
 * Class NotFoundException
 *
 * @category
 * @package theworker\phpmvc\exception
 * @author gabriel.berza
 */
class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}