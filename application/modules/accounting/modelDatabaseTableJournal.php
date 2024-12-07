<?php

class ModelDatabaseTableJournal extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "journal";

        $this->fields[] = ["name" => "date",        "type" => "DATE",             "required" => true];
        $this->fields[] = ["name" => "account_id",  "type" => "INT",              "required" => true];
        $this->fields[] = ["name" => "description", "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "debit",       "type" => self::TYPE_DECIMAL, "required" => false];
        $this->fields[] = ["name" => "credit",      "type" => self::TYPE_DECIMAL, "required" => false];

        $this->inputs["date"]        = ["type" => "date"];
        $this->inputs["account_id"]  = ["type" => "text"];
        $this->inputs["description"] = ["type" => "text", "width" => "large"];
        $this->inputs["debit"]       = ["type" => "text", "width" => "small"];
        $this->inputs["credit"]      = ["type" => "text", "width" => "small"];

        parent::__construct(true);
    }

    public function checkFieldValues(&$record, $result)
    {
        $result["result"] = false;
        $result["message"] = "Field value check failed.";

        $account = new ModelDatabaseTableAccount();
        $accountRecord = $account->getRecordById($record["account_id"]);
        if (!isset($accountRecord["id"]))
        {
            $result["message"] = "The account does not exist.";
            return $result;
        }
        $debit = (isset($record["debit"]) ? $record["debit"] : "");
        $credit = (isset($record["credit"]) ? $record["credit"] : "");
        if ($debit == "" and $credit == "")
        {
            $result["message"] = "Enter a debit or credit amount.";
            return $result;
        }
        if ($debit != "" and $credit != "")
        {
            $result["message"] = "You cannot enter both debit and credit amounts, must be one or the other.";
            return $result;
        }
        if ($debit != "")
        {
            if (!is_numeric($debit))
            {
                $result["message"] = "The debit amount must be numeric.";
                return $result;
            }
            $debit = floatval($debit);
        }
        if ($credit != "")
        {
            if (!is_numeric($credit))
            {
                $result["message"] = "The credit amount must be numeric.";
                return $result;
            }
            $credit = floatval($credit);
        }
        if ($debit == "")
        {
            unset($record["debit"]);
        }
        if ($credit == "")
        {
            unset($record["credit"]);
        }
        $result["result"] = true;
        $result["message"] = "";
        return $result;
    }

}
