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
            "name"     => "id",
            "type"     => "INT",
            "options"  => "AUTO_INCREMENT",
            "key"      => true,
            "required" => false
        ]);

        parent::__construct($host, $user, $password, $autoCreateTable, $defaultRecords);
    }

    public static function getModelForTable($tableName)
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

    public function generateNewRecord() {
        $record = ["id" => 0];
        foreach ($this->fields as $field)
        {
            if ($field["name"] != "id")
            {
                $record[$field["name"]] = null;
            }
        }
        return $record;
    }

    public function getRecordById($id)
    {
        $records = $this->getRecords("id = {$id}");
        if (count($records) == 1)
        {
            return $records[0];
        }
        return [];
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

    public function addRecord($record, $result)
    {
        if (isset($record["id"]))
        {
            unset($record["id"]);
        }
        $result = $this->checkRequiredFields($record, $result);
        if ($result["result"])
        {
            $result["result"] = $this->insertRecord($record);
            if (!$result["result"])
            {
                $result["message"] = "Could not add record: " . $this->getError();
            }
        }
        return $result;
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

    public static function createTables()
    {
        $tableModels = self::getTableModels();
        foreach ($tableModels as $tableModel)
        {
            $dummy = new $tableModel();
        }
    }

    private function checkRequiredFields($record, $result)
    {
        $result["result"] = true;
        $result["message"] = "";
        foreach ($this->fields as $field)
        {
            if ($field["required"] and !isset($record[$field["name"]]))
            {
                $result["result"] = false;
                $result["message"] = "The field {$field["name"]} is required";
                break;
            }
        }
        return $result;
    }

    private static function getTableModels()
    {
        $tableModels = [];
        $fileMatch = strtolower(DIRECTORY_SEPARATOR . "modelDatabaseTable");
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(DOC_ROOT . APP_MODULES_PATH)) as $file)
        {
            $pos = strpos(strtolower($file), $fileMatch);
            if ($pos !== false and !str_contains($file, "Base") and !str_contains($file, "Template"))
            {
                $tableModels[] = substr($file, $pos + 1, strlen($file) - $pos - 5);
            }
        }
        return $tableModels;
    }

}

?>
