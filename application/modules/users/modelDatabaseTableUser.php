<?php

class ModelDatabaseTableUser extends ModelDatabaseTableBase {

    public $lockMaxAttempts = 5;
    public $lockTimeout = 30;


    public function __construct() {
        $this->tableName = "user";
        $this->fields[] = [ "name" => "email",         "type" => "VARCHAR(200)" ];
        $this->fields[] = [ "name" => "name",          "type" => "VARCHAR(200)" ];
        $this->fields[] = [ "name" => "password",      "type" => "VARCHAR(200)" ];
        $this->fields[] = [ "name" => "is_admin",      "type" => "INT"          ];
        $this->fields[] = [ "name" => "access_levels", "type" => "VARCHAR(200)" ];
        $this->fields[] = [ "name" => "last_log_in",   "type" => "INT"          ];
        $this->fields[] = [ "name" => "log_in_fail",   "type" => "INT"          ];

        $this->inputs["email"] = ["type" => "text"];
        $this->inputs["name"] =  ["type" => "text"];
        $this->inputs["password"] = [];
        $this->inputs["is_admin"] = ["type" => "select", "data" => [0, 1] ];
        $this->inputs["access_levels"] = [];

        parent::__construct(true);
    }

    public function hash($input)
    {
        return hash("sha256", $input);
    }

}
