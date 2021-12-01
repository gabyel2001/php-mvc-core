<?php

namespace theworker\phpmvc\db;

use theworker\phpmvc\Application;
use theworker\phpmvc\Model;

/**
 * Class DbModel
 *
 * @category
 * @package theworker\phpmvc\db
 * @author gabriel.berza
 */
abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($p) => ":$p", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") 
                                    VALUES(" . implode(',', $params) . ")");
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();

        return true;
    }

    public function findOne($where)
    {
        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $condition = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $condition");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);

    }

    public static function prepare($sql): \PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);

    }
}