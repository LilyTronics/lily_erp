<?php
/* User table

Access levels: a string of hexadecimal values containing access levels for each table.
This is determined by the constant: ACCESS_INDEX in the database table model.
This user table has ACCESS_INDEX = 1, meaning the first character defines the access level.
Possible access levels:

0x0 = no access
0x1 = read access
0x2 = write access (create/modify records)
0x4 = delete access
0x8 = not used

Access levels can be combined:
0x3 = 0x1 + 0x2             = read and write access
0x7 = 0x1 + 0x2 + 0x4       = read, write and delete access
0xF = 0x1 + 0x2 + 0x4 + 0x8 = all access levels

*/


class ModelDatabaseTableUser extends ModelDatabaseTableBase {

    public const ACCESS_INDEX = 1;

    public $lockMaxAttempts = 5;
    public $lockTimeout = 30;


    public function __construct() {
        $this->tableName = "user";
        $this->fields[] = [ "name" => "email",         "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "name",          "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "password",      "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "is_active",     "type" => "INT",          "required" => true  ];
        $this->fields[] = [ "name" => "is_admin",      "type" => "INT",          "required" => false ];
        $this->fields[] = [ "name" => "access_levels", "type" => "VARCHAR(200)", "required" => false ];
        $this->fields[] = [ "name" => "last_log_in",   "type" => "INT",          "required" => false ];
        $this->fields[] = [ "name" => "log_in_fail",   "type" => "INT",          "required" => false ];

        $this->inputs["email"] = ["type" => "text"];
        $this->inputs["name"] =  ["type" => "text"];
        $this->inputs["password"] = ["type" => "password"];
        $this->inputs["is_active"] = ["type" => "select", "data" => [0, 1] ];
        $this->inputs["is_admin"] = ["type" => "select", "data" => [0, 1] ];
        $this->inputs["access_levels"] = [];

        parent::__construct(true);
    }

    public function checkFieldValues(&$record, $result)
    {
        $result["result"] = false;
        $result["message"] = "Field value check failed.";

        // email and name must be unique, unless we edit an existing record
        $sameValueRecords = $this->getRecords("id <> {$record["id"]} AND email = '{$record["email"]}'");
        if (count($sameValueRecords) > 0)
        {
            $result["message"] = "The email must be unique.";
            return $result;
        }

        $sameValueRecords = $this->getRecords("id <> {$record["id"]} AND name = '{$record["name"]}'");
        if (count($sameValueRecords) > 0)
        {
            $result["message"] = "The name must be unique.";
            return $result;
        }

        if ($record["id"] == 0)
        {
            // New record, hash the password
            $record["password"] = $this->hash($record["password"]);
        }
        else
        {
            // Existing record, remove password
            unset($record["password"]);
        }

        if (isset($record["last_log_in"]))
        {
            unset($record["last_log_in"]);
        }

        if (isset($record["log_in_fail"]))
        {
            unset($record["log_in_fail"]);
        }

        $result["result"] = true;
        $result["message"] = "";
        return $result;
    }

    public function hash($input)
    {
        return hash("sha256", $input);
    }

}
