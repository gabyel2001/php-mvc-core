<?php

namespace theworker\phpmvc\form;

use theworker\phpmvc\Model;

/**
 * Class Form
 *
 * @category
 * @package theworker\phpmvc\form
 * @author gabriel.berza
 */
class Form
{

    public static function begin($action, $method): Form
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, string $attribute): InputField
    {
        return new InputField($model, $attribute);
    }

}