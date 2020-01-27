<?php

/**
 * Database singleton connection
 */
class DB {

    private $_connection;
    private static $_instance = null;

    private function __construct(Config $config)
    {
        try {
            $this->_connection = new PDO(
                'mysql:host=' . $config::DB_HOST . ';dbname=' . $config::DB_NAME,
                $config::DB_USER,
                $config::DB_PASSWORD
                //,[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
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
    public static function init(Config $config)
    {
        if (!self::$_instance)
            self::$_instance = new self($config);
        return self::$_instance;
    }

    public function connect()
    {
        return $this->_connection;
    }
}
?>