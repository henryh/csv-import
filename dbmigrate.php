<?php

/**
 * Database migration file.
 * Run: $ php dbmigrate.php
 */

require 'bootstrap.php';

try {
    $config = new Config();
    $dbi = DB::getInstance($config::DB_HOST, $config::DB_NAME, $config::DB_USER, $config::DB_PASSWORD);
    $db = $dbi->connect();

    $db->beginTransaction();

    // Create import_log table
    $db->exec('DROP TABLE IF EXISTS `import_log`');
    $db->exec('
      CREATE TABLE `import_log` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `file` varchar(300) NOT NULL,
        `date` datetime NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `file` (`file`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');


    // Create user table
    $db->exec('DROP TABLE IF EXISTS `user`');
    $db->exec('
    CREATE TABLE `user` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `number` int(11) NOT NULL,
      `name` varchar(100) NOT NULL,
      `phone` varchar(30) NOT NULL,
      `email` varchar(100) NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `number` (`file`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');

    $db->commit();

} catch (Exception $e) {
    $db->rollback();
    throw $e;
}

?>