<?php

/**
 * Database migration file.
 * Run: $ php dbmigrate.php
 */

require 'bootstrap.php';

try {
    $config = new Config();
    $dbc = DB::init($config);
    $db = $dbc->connect();

    $db->beginTransaction();

    // Create log table
    $db->exec('DROP TABLE IF EXISTS `log`');
    $db->exec('
      CREATE TABLE `log` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
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
      `name` varchar(100) NOT NULL,
      `email` varchar(100) NOT NULL,
      `phone` varchar(100) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ');

    $db->commit();

} catch (Exception $e) {
    $db->rollback();
    throw $e;
}

?>