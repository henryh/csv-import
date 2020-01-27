<?php

/**
 * Work with csv files
 */
class CSVImport
{
    protected $db;
    protected $config;

    function __construct(PDO $db, Config $config)
    {
        $this->db = $db;
        $this->config = $config;
    }

    /**
     * Search file history in log
     *
     * @param string $filePath
     * @return bool
     */
    public function isFileImport(string $filePath): bool
    {
        $logRows = $this->db->query('SELECT COUNT(*) FROM `log` WHERE `file` = "' . $filePath . '"')->fetchColumn();
        return (empty($logRows)) ? false : true;
    }

    /**
     * Save file history in log
     *
     * @param string $filePath
     */
    public function logFileImport(string $filePath)
    {
        return $this->db->prepare("INSERT INTO `log` (`file`, `date`) VALUES (?, now())")->execute([$filePath]);
    }

    /**
     * Get fields by string
     *
     * @return bool
     */
    public function getFields(): string
    {
        return implode(",", $this->config::CSV_FIELDS);
    }

    /**
     * Get fields by string
     *
     * @param resource $file
     * @return array|null
     */
    public function getRows($file): ?array
    {
        $rows = fgetcsv($file, $this->config::CSV_MAX_ROWS, $this->config::CSV_SEPARATOR);
        return (false !== $rows) ? $rows : null;
    }
}
?>