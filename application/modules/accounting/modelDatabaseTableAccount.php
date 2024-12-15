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

}
