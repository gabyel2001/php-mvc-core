<?php

namespace theworker\phpmvc\exception;

/**
 * Class ForbiddenException
 *
 * @category
 * @package theworker\phpmvc\exception
 * @author gabriel.berza
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}