<?php

/**
 * Database singleton connection
 */
class DB {

    private $connection;
    private static $instance = null;

    private static $host;
    private static $name;
    private static $user;
    private static $password;

    private function __construct()
    {
        try {
            $this->connection = new PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$name,
                self::$user, self::$password
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }

    final private function __clone()
    {
        throw new Exception('Feature disabled.');
    }

    final private function __wakeup()
    {
        throw new Exception('Feature disabled.');
    }

    /**
     * Initializing a singleton connection to mysql database via PDO
     *
     * @param Config $config
     */
    public static function getInstance(string $host, string $name, string $user, string $password)
    {
        if (!self::$instance) {
            self::$host = $host;
            self::$name = $name;
            self::$user = $user;
            self::$password = $password;
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function connect()
    {
        return $this->connection;
    }
}
?>