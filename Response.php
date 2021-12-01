<?php

namespace theworker\phpmvc;

/**
 * Class Response
 *
 * @category
 * @package theworker\phpmvc
 * @author gabriel.berza
 */
class Response
{

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }

}