<?php

/**
 * Prepare MySQL params
 */
class RowParams
{
    public $values = [];
    public $valuesToBind = [];
    protected $rows = [];


    function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function make($index)
    {
        foreach($this->rows as $columnName => $columnValue) {
            $param = ":" . $columnName . $index;
            $this->values[] = $param;
            $this->valuesToBind[$param] = $columnValue;
        }
    }
}
?>