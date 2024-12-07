<?php

class ModelDatabaseTableAccount extends ModelDatabaseTableBase {

    public $categories = ["assets", "liabilities", "equity", "income", "expenses"];


    public function __construct() {
        $this->tableName = "account";

        $this->fields[] = ["name" => "number",       "type" => "VARCHAR(200)", "required" => true];
        $this->fields[] = ["name" => "name",         "type" => "VARCHAR(200)", "required" => true];
        $this->fields[] = ["name" => "debit_credit", "type" => "VARCHAR(1)"  , "required" => true];
        $this->fields[] = ["name" => "category",     "type" => "VARCHAR(200)", "required" => true];

        $this->inputs["number"]       = ["type" => "text", "width" => "small"];
        $this->inputs["name"]         = ["type" => "text"];
        $this->inputs["debit_credit"] = ["type" => "select", "data" => ["D", "C"]];
        $this->inputs["category"]     = ["type" => "select", "data" => $this->categories];

        $this->defaultOrder = "number";

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

    public function getAccounts($expandTo)
    {
        $records = [];
        // Check length of the account number
        $query = "SELECT MAX(LENGTH(number)) as max_length FROM ";
        $query .= $this->databaseTable;
        $result = $this->selectRecordsFromQuery($query);
        if ($result[0] and count($result[1]) == 1)
        {
            $max = intval($result[1][0]["max_length"]);
            // Create filters
            $query = "";
            // Create lowest filter
            $filter = str_replace("0", "", $expandTo) . "_";
            $filter .= str_repeat("0", $max - strlen($filter));
            $query = "number LIKE '{$filter}'";
            // Create filters for one up until top is reached
            $pos = strpos($filter, "_");
            while ($pos > 0)
            {
                $filter = substr($filter, 0, $pos - 1) . "_";
                $filter .= str_repeat("0", $max - strlen($filter));
                $query .= " or number LIKE '{$filter}'";
                $pos = strpos($filter, "_");
            }
            $records = $this->getRecords($query, "number");
            for ($i = 0; $i < count($records); $i++)
            {
                $records[$i]["debit"] = 0;
                $records[$i]["credit"] = 0;
            }
        }
        return $records;
    }

}
