<?php

/**
 * App configuration
 */
class Config
{
    /**
     * Database config
     */
    const DB_HOST = 'localhost';
    const DB_NAME = 'csvimport';
    const DB_USER = 'root';
    const DB_PASSWORD = '1';

    /**
     * File config
     */
    const FILE_DIRECTORY = 'import';
    const FILE_EXTENSION = 'csv';

    /**
     * CSV config
     */
    const CSV_SEPARATOR = ',';
    const CSV_MAX_ROWS = 100000;
    const CSV_FIELDS = ['number', 'name', 'phone', 'email']; // If edit this array - edit migration too!
}

?>