<?php
namespace Prinx\Utils;

class DB
{
    public static function load(array $params)
    {
        $dsn = $params['driver'];
        $dsn .= ':host=' . $params['host'];
        $dsn .= ';port=' . $params['port'];
        $dsn .= ';dbname=' . $params['dbname'];

        $user = $params['user'];
        $pass = $params['password'];

        try {
            return new \PDO($dsn, $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => true,
            ]);
        } catch (\PDOException $e) {
            exit('Unable to connect to the database.<br/><br/><span style="color:violet;">Database Parameters</span>:<br/>Driver: ' . $params['driver'] . '<br/>Host: ' . $params['host'] . '<br/>Port: ' . $params['port'] . '<br/>Database: ' . $params['dbname'] . '<br/>User: ' . $params['user'] . '<br/>Password: You cannot see the password here! Check directly in your configurations.<br/><br/>Also check if the parameters are correct, if the ' . $params['driver'] . " service is running on the server which host the database and if there is an effective internet cconnection between the server that hosts your appication's server and the server that hosts the databse(s)." . '<br/><br/><span style="color:red;">ERROR: ' . $e->getMessage() . '</span>');
        }
    }

    public static function createInsertSqlString(string $table, array $fields)
    {
        $fields_str = "";
        $values_str = "";

        foreach ($fields as $value) {
            $fields_str .= $value . ", ";
            $values_str .= ":" . $value . ", ";
        }

        $fields_str = rtrim($fields_str, ', ');
        $values_str = rtrim($values_str, ', ');

        return "INSERT INTO $table ($fields_str) VALUES ($values_str)";
    }

    public static function insert(array $data, string $table, \PDO $db)
    {
        $sql = self::createInsertSqlString($table, array_keys($data));
        $stmt = $db->prepare($sql);
        $stmt->execute($data);

        $stmt->closeCursor();
    }

    public static function resultWithTrueInt(array $arr)
    {
        foreach ($arr as $key => $value) {
            if (!is_null($value) && Str::isIntegerNumeric($value)) {
                $arr[$key] = intval($value);
            }
        }

        return $arr;
    }

    public static function resultWithTrueFloat(array $arr)
    {
        foreach ($arr as $key => $value) {
            if (!is_null($value) && Str::isFloatNumeric($value)) {
                $arr[$key] = floatval($value);
            }
        }

        return $arr;
    }

    public static function resultWithTrueNumeric(array $arr)
    {
        foreach ($arr as $key => $value) {
            if (!is_null($value) && Str::isIntegerNumeric($value)) {
                $arr[$key] = intval($value);
            } elseif (!is_null($value) && Str::isFloatNumeric($value)) {
                $arr[$key] = floatval($value);
            }
        }

        return $arr;
    }
}
