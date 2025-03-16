<?php

namespace models;

use src\Database;

class Courier
{
    public static function getAllCouriers(): array|false
    {
        return Database::getInstance()->findAll('couriers');
    }
}