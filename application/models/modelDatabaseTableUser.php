<?php

class ModelDatabaseTableUser extends ModelDatabaseTableBase {

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

        parent::__construct("user", $fields);
    }

}
