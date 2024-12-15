<?php

class ModelDatabaseTableSetting extends ModelDatabaseTableBase
{

    public function __construct()
    {
        $this->tableName = "setting";

        $this->fields[] = $this->createField("setting_name",  "VARCHAR(200)", true);
        $this->fields[] = $this->createField("setting_value", "VARCHAR(200)", true);

        $this->inputs["setting_name"]  = [];
        $this->inputs["setting_value"] = $this->createInput("text");

        $defaultRecords = [
            [ "setting_name" => "database_version", "setting_value" => DATABASE_VERSION     ],
            [ "setting_name" => "landing_page",     "setting_value" => DEFAULT_LANDING_PAGE ],
            [ "setting_name" => "theme_color",      "setting_value" => DEFAULT_COLOR        ]
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
