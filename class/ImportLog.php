<?php

/**
 * Work with the file import log
 */
class ImportLog
{

    protected $db;

    function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Search a record in the log
     *
     * @param string $filePath
     * @return bool
     */
    public function isFileImport(string $filePath): bool
    {
        $rows = $this->db->query('SELECT COUNT(*) FROM `import_log` WHERE `file` = "' . $filePath . '"')->fetchColumn();
        return (empty($rows)) ? false : true;
    }

    /**
     * Save a recored to the log
     *
     * @param string $filePath
     */
    public function logFileImport(string $filePath)
    {
        $rows = $this->db->prepare("INSERT INTO `import_log` (`file`, `date`) VALUES (?, now())")->execute([$filePath]);
        return (empty($rows)) ? false : true;
    }

}