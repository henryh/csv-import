<?php

/**
 * Work with csv files
 */
class CSV
{
    protected $maxRows;
    protected $fieldSeparator;

    /**
     * @param int $maxRows
     * @return string $fieldSeparator
     */
    function __construct(int $maxRows = 100000, string $fieldSeparator = ",")
    {
        $this->maxRows = $maxRows;
        $this->fieldSeparator = $fieldSeparator;
    }

    /**
     * Get fields by string
     *
     * @param resource $file
     * @return array|null
     */
    public function getRows($file): ?array
    {
        $rows = fgetcsv($file, $this->maxRows, $this->fieldSeparator);
        return (false !== $rows) ? $rows : null;
    }
}
?>