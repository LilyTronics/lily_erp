<?php

class ModelDatabaseTableAccount extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "account";

        $this->fields[] = [ "name" => "parent_id",    "type" => "INT"         , "required" => true  ];
        $this->fields[] = [ "name" => "number",       "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "name",         "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "debit_credit", "type" => "VARCHAR(1)"  , "required" => true  ];
        $this->fields[] = [ "name" => "category",     "type" => "VARCHAR(200)", "required" => false ];

        $this->inputs["parent_id"]    = ["type" => "text", "width" => "small"];
        $this->inputs["number"]       = ["type" => "text", "width" => "small"];
        $this->inputs["name"]         = ["type" => "text"];
        $this->inputs["debit_credit"] = ["type" => "select", "data" => ["D", "C"] ];
        $this->inputs["category"]     = ["type" => "text"];

        parent::__construct(true);
    }

    public function checkFieldValues($record, $result)
    {
        $result["result"] = false;
        $result["message"] = "Field value check failed.";

        // Number field must represent a number
        if (!is_numeric($record["number"]))
        {
            $result["message"] = "The number must be numeric.";
            return $result;
        }

        // Number and name must be unique, unless we edit an existing record
        $sameValueRecords = $this->getRecords("id <> {$record["id"]} AND number = '{$record["number"]}'");
        if (count($sameValueRecords) > 0)
        {
            $result["message"] = "The number must be unique.";
            return $result;
        }

        $sameValueRecords = $this->getRecords("id <> {$record["id"]} AND name = '{$record["name"]}'");
        if (count($sameValueRecords) > 0)
        {
            $result["message"] = "The name must be unique.";
            return $result;
        }

        // Debit credit must be D or C
        if ($record["debit_credit"] != "D" and $record["debit_credit"] != "C")
        {
            $result["message"] = "The debit credit must be 'D' or 'C'.";
            return $result;
        }

        $result["result"] = true;
        $result["message"] = "";
        return $result;
    }

}
