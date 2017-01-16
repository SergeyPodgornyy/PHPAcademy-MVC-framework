<?php

namespace Model\Driver;

use PDO;

class Engine
{
    private static $connections = [];

    public static function setConnection($name, $config)
    {
        if (isset(self::$connections[$name])) {
            return false;
        }
        $dsn = "{$config['type']}:host={$config['host']};dbname={$config['name']}";
        $username = $config['user'];
        $password = $config['password'];
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $config['charset'],
        ];

        self::$connections[$name] = new TransactionPDO($dsn, $username, $password, $opt);
        return self::$connections[$name];
    }

    public static function getConnection($name)
    {
        if (isset(self::$connections[$name])) {
            return self::$connections[$name];
        }
        return false;
    }
}
