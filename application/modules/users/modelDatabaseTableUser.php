<?php

class ModelDatabaseTableUser extends ModelDatabaseTableBase {

    public $lockMaxAttempts = 5;
    public $lockTimeout = 30;

    public function __construct() {
        $tableName = "user";
        $fields = [
            [ "Name"    => "id",
              "Type"    => "INT",
              "Options" => "AUTO_INCREMENT",
              "Key"     => true ],
            [ "Name"    => "email",
              "Type"    => "VARCHAR(200)" ],
            [ "Name"    => "name",
              "Type"    => "VARCHAR(200)" ],
            [ "Name"    => "password",
              "Type"    => "VARCHAR(200)" ],
            [ "Name"    => "is_admin",
              "Type"    => "INT" ],
            [ "Name"    => "access_levels",
              "Type"    => "VARCHAR(200)" ],
            [ "Name"    => "last_log_in",
              "Type"    => "INT" ],
            [ "Name"    => "log_in_fail",
              "Type"    => "INT" ],
        ];
        parent::__construct($tableName, $fields, true);
    }

    public function hash($input)
    {
        return hash("sha256", $input);
    }
}
