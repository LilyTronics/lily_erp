<?php

class ModelDatabaseTableBase extends ModelDatabaseTable {

    public $inputs = [];
    protected $returnUri = "";

    public function __construct($autoCreateTable=false, $defaultRecords=[]) {
        $config = new ModelConfiguration(CONFIG_FILE);
        $host = $config->getValue("sql", "host");
        $user = $config->getValue("sql", "user");
        $password = $config->getValue("sql", "password");
        $this->database = $config->getValue("sql", "database");

        // Insert ID field as first field, for every table the same
        array_unshift($this->fields, [
            "Name"    => "id",
            "Type"    => "INT",
            "Options" => "AUTO_INCREMENT",
            "Key"     => true
        ]);

        parent::__construct($host, $user, $password, $autoCreateTable, $defaultRecords);
    }

    public static function GetModelForTable($tableName)
    {
        $table = null;
        // Check if the database file exists, else we can get a fatal error
        $tableName = str_replace(["-", "_"], "", $tableName);
        $tableModel = "ModelDatabaseTable{$tableName}";
        $fileMatch = strtolower(DIRECTORY_SEPARATOR . "{$tableModel}.php");
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(DOC_ROOT . APP_MODULES_PATH)) as $file)
        {
            if (str_ends_with(strtolower($file), $fileMatch))
            {
                // File exists so model must be there
                $table = new $tableModel();
                break;
            }
        }
        return $table;
    }

    public function getReturnUri()
    {
        return $this->returnUri;
    }

    public function generateNewRecord() {
        $record = ["id" => 0];
        foreach ($this->fields as $field)
        {
            if ($field["Name"] != "id")
            {
                $record[$field["Name"]] = null;
            }
        }
        return $record;
    }

    public function getRecords($filterExpression="", $orderExpression="", $groupExpression="", $start=0, $count=0,
                               $fields=["*"], $join="", $joinTable="", $joinExpression="", $joinFields=["*"])
    {
        $records = $this->selectRecords($filterExpression, $orderExpression, $groupExpression, $start, $count,
                                        $fields, $join, $joinTable, $joinExpression, $joinFields);
        if (!$records[0])
        {
            DEBUG_LOG->writeMessage("Error getting records for table: {$this->tableName}");
            DEBUG_LOG->writeMessage($this->getError());
            return [];
        }
        return $records[1];
    }

    public function addRecord($record)
    {
        if (isset($record["id"]))
        {
            unset($record["id"]);
        }
        return $this->insertRecord($record);
    }

    public function modifyRecord($record)
    {
        $expression = "id = {$record["id"]}";
        unset($record["id"]);
        return $this->updateRecord($record, $expression);
    }

    public function removeRecord($record)
    {
        $expression = "id = {$record["id"]}";
        return $this->deleteRecord($expression);
    }

}

?>
