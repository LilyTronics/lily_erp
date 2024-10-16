<?php

class ModelDatabaseTableUser extends ModelDatabaseTableBase {

    public $lockMaxAttempts = 5;
    public $lockTimeout = 30;

    public function __construct() {
        $fields = [];
        $fields[] = [ "Name"    => "id",
                      "Type"    => "INT",
                      "Options" => "AUTO_INCREMENT",
                      "Key"     => true ];
        $fields[] = [ "Name"    => "email",
                      "Type"    => "VARCHAR(200)" ];
        $fields[] = [ "Name"    => "name",
                      "Type"    => "VARCHAR(200)" ];
        $fields[] = [ "Name"    => "password",
                      "Type"    => "VARCHAR(200)" ];
        $fields[] = [ "Name"    => "is_admin",
                      "Type"    => "INT" ];
        $fields[] = [ "Name"    => "access_levels",
                      "Type"    => "VARCHAR(200)" ];
        $fields[] = [ "Name"    => "last_log_in",
                      "Type"    => "INT" ];
        $fields[] = [ "Name"    => "log_in_fail",
                      "Type"    => "INT" ];

        parent::__construct("user", $fields, true);
    }

    public function hash($input)
    {
        return hash("sha256", $input);
    }
}