<?php

/*
 * This file is part of the PHPUtils package.
 *
 * (c) Prince Dorcis <princedorcis@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prinx\Utils;

/**
 * Database Utilities class
 *
 * @author Prince Dorcis <princedorcis@gmail.com>
 */
class DB
{
    /**
     * Returns a PDO connection to the database
     *
     * @param array $params
     * @param array $option
     * @return \PDO
     * @throws \Exception If unable to connect to the database
     */
    public static function load(array $params, array $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_PERSISTENT => true,
    ]) {

        $required = ['dbname' /* 'driver', 'host', 'port', 'user', 'password' */];
        foreach ($required as $paramName) {
            if (!isset($params[$paramName])) {
                throw new \Exception('Parameter ' . $paramName . ' is required to connect to the database.');
            }
        }

        $dsn = $params['driver'] ?? 'mysql';
        $dsn .= ':host=' . $params['host'] ?? 'localhost';
        $dsn .= ';port=' . $params['port'] ?? 3306;
        $dsn .= ';dbname=' . $params['dbname'];

        $user = $params['user'] ?? '';
        $pass = $params['password'] ?? '';

        try {
            return new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException('ERROR CONNECTING TO DATABASE: ' . $e->getMessage() . ' in file ' . $e->getFile() . ':' . $e->getLine());
        }
    }

    /**
     * Create an INSERT query string
     *
     * @param string $tableName
     * @param array $fields
     * @return string
     */
    public static function createInsertSqlString($tableName, $fields)
    {
        $fields_str = "";
        $values_str = "";

        foreach ($fields as $value) {
            $fields_str .= $value . ", ";
            $values_str .= ":" . $value . ", ";
        }

        $fields_str = rtrim($fields_str, ', ');
        $values_str = rtrim($values_str, ', ');

        return "INSERT INTO $tableName ($fields_str) VALUES ($values_str)";
    }

    /**
     * Insert a row to a table of the database
     *
     * @param array $data Associative array mapping the columns names of the table to the values that will inserted
     * @param string $tableName
     * @param \PDO $db
     * @return int The ID of the inserted row
     */
    public static function insert($data, $tableName, $db)
    {
        $sql = self::createInsertSqlString($tableName, array_keys($data));
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $stmt->closeCursor();

        return $db->lastInsertId();
    }

    /**
     * Parse a database result replacing integers by real integers
     * By default, the database return everything as string
     *
     * @param array $arr
     * @return array
     * @todo Support for object (sometimes the response is an object instead of array)
     */
    public static function resultWithTrueInt($arr)
    {
        foreach ($arr as $key => $value) {
            if (!is_null($value) && Str::isNumeric($value)) {
                $arr[$key] = intval($value);
            }
        }

        return $arr;
    }

    /**
     * I wonder the necessity of this function
     *
     * @param array $data
     * @return string
     */
    public static function createWhereInRange(array $data)
    {
        return '(' . implode(',', $data) . ')';
    }
}
