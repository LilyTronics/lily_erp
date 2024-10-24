<?php

class ModelDatabaseTableAccount extends ModelDatabaseTableBase {

    public function __construct() {
        $tableName = "account";
        $fields = [
            [ "Name"    => "id",
              "Type"    => "INT",
              "Options" => "AUTO_INCREMENT",
              "Key"     => true ],
            [ "Name"    => "parent_id",
              "Type"    => "INT"],
            [ "Name"    => "level",
              "Type"    => "INT"],
            [ "Name"    => "number",
              "Type"    => "VARCHAR(200)"],
            [ "Name"    => "name",
              "Type"    => "VARCHAR(200)"],
            [ "Name"    => "debit_credit",
              "Type"    => "VARCHAR(1)"],
            [ "Name"    => "category",
              "Type"    => "VARCHAR(200)"]
        ];
        parent::__construct($tableName, $fields, true);
    }

}
