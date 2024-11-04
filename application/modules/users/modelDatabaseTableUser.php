<?php

class ModelDatabaseTableUser extends ModelDatabaseTableBase {

    public $lockMaxAttempts = 5;
    public $lockTimeout = 30;


    public function __construct() {
        $this->tableName = "user";
        $this->fields[] = [ "Name" => "email",         "Type" => "VARCHAR(200)" ];
        $this->fields[] = [ "Name" => "name",          "Type" => "VARCHAR(200)" ];
        $this->fields[] = [ "Name" => "password",      "Type" => "VARCHAR(200)" ];
        $this->fields[] = [ "Name" => "is_admin",      "Type" => "INT"          ];
        $this->fields[] = [ "Name" => "access_levels", "Type" => "VARCHAR(200)" ];
        $this->fields[] = [ "Name" => "last_log_in",   "Type" => "INT"          ];
        $this->fields[] = [ "Name" => "log_in_fail",   "Type" => "INT"          ];

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
