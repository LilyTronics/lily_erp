<?php

class ModelDatabaseTableSetting extends ModelDatabaseTableBase
{

    public function __construct()
    {
        $this->tableName = "setting";

        $this->fields[] = [ "name" => "setting_name",  "type" => "VARCHAR(200)", "required" => true ];
        $this->fields[] = [ "name" => "setting_value", "type" => "VARCHAR(200)", "required" => true ];

        $this->inputs["setting_value"] = ["type" => "text"];

        $defaultRecords = [
            [ "setting_name" => "database_version", "setting_value" => "0.1"     ],
            [ "setting_name" => "theme_color",      "setting_value" => "#0066aa" ]
        ];

        parent::__construct(true, $defaultRecords);
    }

    public function getSettings()
    {
        $settings = [];
        $records = $this->getRecords();
        foreach ($records as $record)
        {
            $settings[$record["setting_name"]] = $record["setting_value"];
        }
        return $settings;
    }

    public function checkFieldValues(&$record, $result)
    {
        $result["result"] = false;
        $result["message"] = "Field value check failed.";
        // Settings records are existing records, cannot be a new record
        // Find the record ID from the database
        $records = $this->getRecords("setting_name = '{$record["setting_name"]}'");
        if (count($records) != 1)
        {
            $result["message"] = "Invalid setting name: '{$record["setting_name"]}'.";
            return $result;
        }
        // Copy ID from the matching record
        $record["id"] = $records[0]["id"];
        $result["result"] = true;
        $result["message"] = "";
        return $result;
    }

}