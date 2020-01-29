<?php

/**
 * CSV import script
 * Load data from csv to database.
 * Config there: app/Config.php
 * Run: $ php csvimport.php
 */

require_once('bootstrap.php');

// Get environment instances
$config = new Config();
$file = new File($config::FILE_DIRECTORY, $config::FILE_EXTENSION);
$csv = new CSV($config::CSV_MAX_ROWS, $config::CSV_SEPARATOR);
$dbi = DB::getInstance($config::DB_HOST, $config::DB_NAME, $config::DB_USER, $config::DB_PASSWORD);
$db = $dbi->connect();
$importLog = new ImportLog($db);


if (empty($files = $file->getAll())) {
    print_r('No matching files found');
    exit;
}

$imported_files = 0;

foreach ($files as $filePath) {

    if ($importLog->isFileImport($filePath)) continue;

    $fields = implode(",", $config::CSV_FIELDS);

    $csvFile = fopen($filePath, "r");

    $rowIndex = 0;
    $values = [];
    $valuesToBind = [];
    while ($rows = $csv->getRows($csvFile)) {
        $params = new RowParams($rows);
        $params->make($rowIndex++);
        $values[] = "(" . implode(", ", $params->values) . ")";
        $valuesToBind += $params->valuesToBind;
        $params;
    }

    try {
        $db->beginTransaction();

        // Save log
        if (!($importLog->logFileImport($filePath)))
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