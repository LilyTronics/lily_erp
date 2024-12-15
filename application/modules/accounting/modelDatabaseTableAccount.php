<?php

class ModelDatabaseTableAccount extends ModelDatabaseTableBase {

    public $categories = ["assets", "liabilities", "equity", "income", "expenses"];


    public function __construct() {
        $this->tableName = "account";

        $this->fields[] = $this->createField("number",       "VARCHAR(200)", true);
        $this->fields[] = $this->createField("name",         "VARCHAR(200)", true);
        $this->fields[] = $this->createField("debit_credit", "VARCHAR(1)"  , true);
        $this->fields[] = $this->createField("category",     "VARCHAR(200)", true);

        $this->inputs["number"]       = $this->createInput("text", "small");
        $this->inputs["name"]         = $this->createInput("text");
        $this->inputs["debit_credit"] = $this->createInput("select", data:["D", "C"]);
        $this->inputs["category"]     = $this->createInput("select", data:$this->categories);

        $this->defaultOrder = "number";
        $this->dataListFields = ["name", "number"];

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

    public function getAccounts($expand)
    {
        $records = [];
        // Check length of the account number
        $query = "SELECT MAX(LENGTH(number)) as max_length FROM ";
        $query .= $this->databaseTable;
        $result = $this->selectRecordsFromQuery($query);
        if ($result[0] and count($result[1]) == 1)
        {
            $max = intval($result[1][0]["max_length"]);
            // Default query
            $query = "number LIKE '_" . str_repeat("0", $max - 1) . "'";
            if ($expand != "")
            {
                // Expand determines the filters
                //   Expand | filters
                //  --------+------------------
                //   x000   | x0%, x_00
                //   xy00   | xy0%, xy_0, x_00,
                //   xyz0   | xyz_, xy_0, x_00

                // Find position of ending zeros
                // 1000 -> 1
                // 0100 -> 2
                // 1010 -> 3
                $zeros = "0";
                $pos = 0;
                while (strlen($zeros) < $max)
                {
                    if (str_ends_with($expand, $zeros))
                    {
                        $pos = strlen($expand) - strlen($zeros);
                    }
                    $zeros .= "0";
                }
                if ($pos > 0)
                {
                    if ($pos < $max - 1)
                    {
                        $filter = substr($expand, 0, $pos + 1) . "%";
                        $query .= " OR number LIKE '{$filter}'";
                    }
                    while ($pos > 0)
                    {
                        $filter = substr($expand, 0, $pos) . "_";
                        $filter .= str_repeat("0", $max - $pos - 1);
                        $query .= " OR number LIKE '{$filter}'";
                        $pos--;
                    }
                }
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
