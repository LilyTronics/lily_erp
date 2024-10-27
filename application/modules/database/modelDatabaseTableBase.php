<?php

class ModelDatabaseTableBase extends ModelDatabaseTable {

    public function __construct($tableName, $fields=null, $autoCreateTable=false, $defaultRecords=[]) {
        $config = new ModelConfiguration(CONFIG_FILE);
        $db = $config->getValue("sql", "database");
        $host = $config->getValue("sql", "host");
        $user = $config->getValue("sql", "user");
        $password = $config->getValue("sql", "password");

        parent::__construct($db, $tableName, $fields, $host, $user, $password, $autoCreateTable, $defaultRecords);
    }

    public static function GetModelForTable($tableName)
    {
        $tableName = str_replace(["-", "_"], "", $tableName);
        $tableModel = "ModelDatabaseTable{$tableName}";
        $table = new $tableModel();
        return $table;
    }

    public function getNewRecord() {
        $record = [];
        foreach ($this->fields as $field)
        {
            if ($field["Name"] != "id")
            {
                $record[$field["Name"]] = null;
            }
        }
        return $record;
    }

    public function getRecordView()
    {
        $view = [];
        foreach ($this->fields as $field)
        {
            if ($field["Name"] != "id")
            {
                if (!isset($field["Input"]))
                {
                    $view[$field["Name"]] = "";
                }
                else
                {
                    $view[$field["Name"]] = $field["Input"];
                }
            }
        }
        return $view;
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
