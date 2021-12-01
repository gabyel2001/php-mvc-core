<?php

namespace theworker\phpmvc;

use theworker\phpmvc\db\DbModel;

/**
 * Class UserModel
 *
 * @category
 * @package theworker\phpmvc
 * @author gabriel.berza
 */
abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}