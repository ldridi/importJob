<?php

require_once __DIR__ . '/lib/Config.php';

class DB {
    private static $instance;

    public static function getConnection()
    {
        $database = Config::get('database');

        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host='.$database['host'].';dbname='.$database['dbname'], $database['user'], $database['password']);
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage() . "\n");
            }
        }

        return self::$instance;
    }
}