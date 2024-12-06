<?php

class ModelDatabaseTableJournal extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "journal";

        $this->fields[] = ["name" => "date",        "type" => "DATE",             "required" => true];
        $this->fields[] = ["name" => "account_id",  "type" => "INT",              "required" => true];
        $this->fields[] = ["name" => "description", "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "linked_item", "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "debit",       "type" => self::TYPE_DECIMAL, "required" => true];
        $this->fields[] = ["name" => "credit",      "type" => self::TYPE_DECIMAL, "required" => true];

        $this->inputs["date"]        = ["type" => "date"];
        $this->inputs["account_id"]  = ["type" => "text"];
        $this->inputs["description"] = ["type" => "text"];
        $this->inputs["linked_item"] = ["type" => "text"];
        $this->inputs["debit"]       = ["type" => "text"];
        $this->inputs["credit"]      = ["type" => "text"];

        parent::__construct(true);
    }

    public function checkFieldValues($record, $result)
    {
        $result["result"] = false;
        $result["message"] = "Field value check failed.";
        return $result;
    }

}
