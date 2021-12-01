<?php

namespace theworker\phpmvc;

use theworker\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}