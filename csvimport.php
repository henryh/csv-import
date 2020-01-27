<?php

/**
 * CSV import script
 * Load data from csv to database.
 * Config there: app/Config.php
 * Run: $ php csvimport.php
 */

require 'bootstrap.php';

$config = new Config();
$fileFinder = new FileFinder($config);
$dbc = DB::init($config);
$db = $dbc->connect();
$CSVImport = new CSVImport($db, $config);

$files = $fileFinder->getAll();

if (empty($files)) {
    print_r('No matching files found');
    exit;
}

$imported_files = 0;

foreach ($files as $filePath) {

    if ($CSVImport->isFileImport($filePath)) continue;

    $fields = $CSVImport->getFields();

    $file = fopen($filePath, "r");

    $rowIndex = 0;
    $values = [];
    $valuesToBind = [];
    while ($rows = $CSVImport->getRows($file)) {
        $params = new RowParams($rows);
        $params->make($rowIndex++);
        $values[] = "(" . implode(", ", $params->values) . ")";
        $valuesToBind += $params->valuesToBind;
    }

    try {
        $db->beginTransaction();

        // Save log
        if (empty($CSVImport->logFileImport($filePath)))
            throw new Exception('File not logged.');

        $imported_files++;

        // Save rows
        $dbStatement = $db->prepare("INSERT INTO `user` ($fields) VALUES " . implode(", ", $values));
        foreach ($valuesToBind as $param => $val) {
            $dbStatement->bindValue($param, $val);
        }
        $dbStatement->execute();

        $db->commit();

    } catch (Exception $e) {
        $db->rollback();
        throw $e;
    }
}

print_r(
    'Work is completed. ' . PHP_EOL .
    'Processed new files: ' . $imported_files . PHP_EOL
);

exit;

?>