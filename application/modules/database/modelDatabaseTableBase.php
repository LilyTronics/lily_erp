<?php

class ModelDatabaseTableBase extends ModelDatabaseTable
{
    public $defaultOrder = "";
    public $inputs = [];
    public $dataListFields = [];


    public function __construct($autoCreateTable=false, $defaultRecords=[])
    {
        $config = new ModelConfiguration(CONFIG_FILE);
        $host = $config->getValue("sql", "host");
        $user = $config->getValue("sql", "user");
        $password = $config->getValue("sql", "password");
        $this->database = $config->getValue("sql", "database");

        // Insert ID field as first field, for every table the same
        array_unshift($this->fields, $this->createField("id", "INT", true, "AUTO_INCREMENT", true));

        parent::__construct($host, $user, $password, $autoCreateTable, $defaultRecords);
    }

    protected function createField($name, $type, $required, $options="", $key=null)
    {
        $field = ["name" => $name, "type" => $type, "required" => $required];
        if ($options != "")
        {
            $field["options"] = $options;
        }
        if ($key !== null)
        {
            $field["key"] = $key;
        }
        return $field;
    }

    protected function createInput($type, $width="", $data=null)
    {
        $input = ["type" => $type];
        if ($width != "")
        {
            $input["width"] = $width;
        }
        if ($data != null)
        {
            $input["data"] = $data;
        }
        return $input;
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

    public function generateNewRecord()
    {
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
        $record = $this->generateNewRecord();
        if ($id > 0)
        {
            $records = $this->getRecords("id = {$id}");
            if (count($records) == 1)
            {
                $record =  $records[0];
            }
            else
            {
                $record = [];
            }
        }
        return $record;
    }

    public function getRecords($filterExpression="", $orderExpression="", $groupExpression="", $start=0, $count=0,
                               $fields=["*"], $join="", $joinTable="", $joinExpression="", $joinFields=["*"])
    {
        if ($orderExpression == "")
        {
            $orderExpression = $this->defaultOrder;
        }
        $records = $this->selectRecords($filterExpression, $orderExpression, $groupExpression, $start, $count,
                                        $fields, $join, $joinTable, $joinExpression, $joinFields);
        if (!$records[0])
        {
            DEBUG_LOG->writeMessage("Error getting records for table: {$this->tableName}.");
            DEBUG_LOG->writeMessage($this->getError());
            return [];
        }
        if (method_exists($this, "convertFieldValues"))
        {
            $records[1] = $this->convertFieldValues($records[1]);
        }
        return $records[1];
    }

    public function listRecords($id = 0)
    {
        $filter = ($id > 0 ? "id = $id" : "");
        $records = $this->selectRecords($filter);
        if (!$records[0])
        {
            DEBUG_LOG->writeMessage("Error getting records for table: {$this->tableName}.");
            DEBUG_LOG->writeMessage($this->getError());
            return [];
        }
        $list = [];
        if (count($this->dataListFields) == 2)
        {
            foreach ($records[1] as $record)
            {
                $list[] = "{$record[$this->dataListFields[0]]} ({$record[$this->dataListFields[1]]})";
            }
        }
        return $list;
    }

    public function addRecord($record, $result)
    {
        $result = $this->checkRecord($record, $result);
        if ($result["result"])
        {
            if (isset($record["id"]))
            {
                unset($record["id"]);
            }
            $result["message"] = "";
            $result["result"] = $this->insertRecord($record);
            if (!$result["result"])
            {
                $result["message"] = "Could not add record: " . $this->getError() . ".";
            }
        }
        return $result;
    }

    public function modifyRecord($record, $result)
    {
        $result = $this->checkRecord($record, $result);
        if ($result["result"])
        {
            $expression = "id = {$record["id"]}";
            unset($record["id"]);
            $result["message"] = "";
            $result["result"] = $this->updateRecord($record, $expression);
            if (!$result["result"])
            {
                $result["message"] = "Could not update record: " . $this->getError() . ".";
            }
        }
        return $result;
    }

    public function removeRecord($record, $result)
    {
        $result["result"] = isset($record["id"]);
        if (!$result["result"])
        {
            $result["message"] = "The id field is required";
        }
        else
        {
            $expression = "id = {$record["id"]}";
            $result["message"] = "";
            $result["result"] = $this->deleteRecord($expression);
            if (!$result["result"])
            {
                $result["message"] = "Could not update record: " . $this->getError() . ".";
            }
        }
        return $result;
    }

    public static function createTables()
    {
        $tableModels = self::getTableModels();
        foreach ($tableModels as $tableModel)
        {
            $dummy = new $tableModel();
        }
    }

    public function convertIdToFilter($query, $table)
    {
        // The query can be the following:
        // integer representing the ID of a record                  : query = 3
        // string containing an integer representing record ID      : query = '3'
        // string containing a text representing fields of a record : query = 'field1 (field2)'
        $filter = "id = -1";
        if (is_numeric($query))
        {
            // Must be ID
            $filter = "id = {$query}";
        }
        else if (is_string($query))
        {
            if (str_contains($query, " ("))
            {
                $parts = explode(" (", $query);
                if (count($parts) == 2)
                {
                    $parts[1] = trim($parts[1], ")");
                    $table->dataListFields;
                    $filter = "{$table->dataListFields[0]} = '{$parts[0]}' OR ";
                    $filter .= "{$table->dataListFields[1]} = '{$parts[1]}'";
                }
            }
        }
        return $filter;
    }

    private function checkRecord(&$record, $result)
    {
        $result = $this->checkRequiredFields($record, $result);
        if ($result["result"])
        {
            $result["result"] = false;
            $result["message"] = "No field values were checked.";
            if (method_exists($this, "checkFieldValues"))
            {
                $result = $this->checkFieldValues($record, $result);
            }
        }
        return $result;
    }

    private function checkRequiredFields($record, $result)
    {
        $result["result"] = true;
        $result["message"] = "";
        foreach ($this->fields as $field)
        {
            if ($field["required"])
            {
                $fieldName = $field["name"];
                $friendlyName = str_replace("_", " ", $fieldName);
                $fieldType = $field["type"];
                $fieldValue = (isset($record[$fieldName]) ? $record[$fieldName] : null);
                // If the fields ends with _id it is a special field that can also
                // contain an identifier in the form of a string
                if (str_ends_with($fieldName, "_id") and is_string($fieldValue))
                {
                    // Handle as string if it is a string
                    $friendlyName = str_replace("_id", "", $friendlyName);
                    $fieldType = "VARCHAR";
                }
                switch (true)
                {
                    case ($fieldValue === null or $fieldValue == ""):
                        $result["result"] = false;
                        $result["message"] = "The {$friendlyName} can not be empty.";
                        break;

                    case ($fieldType == "INT"):
                        if (!is_numeric($fieldValue))
                        {
                            $result["result"] = false;
                            $result["message"] = "The {$friendlyName} must be numeric.";
                            break;
                        }
                        break;

                    case ($fieldType == "DATE" or str_starts_with($fieldType, "VARCHAR")):
                        if (!is_string($fieldValue))
                        {
                            $result["result"] = false;
                            $result["message"] = "The {$friendlyName} must be text.";
                        }
                        break;

                    default:
                        $result["result"] = false;
                        $result["message"] = "Could not process {$friendlyName} of type {$fieldType}.";
                }
                if (!$result["result"])
                {
                    break;
                }
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
