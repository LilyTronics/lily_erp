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
              "Type"    => "INT",
              "Input"   => "text|datalist|account:id|width:160"],
            [ "Name"    => "level",
              "Type"    => "INT",
              "Input"   => "number|1,3|width:80"],
            [ "Name"    => "number",
              "Type"    => "VARCHAR(200)",
              "Input"   => "text|width:160"],
            [ "Name"    => "name",
              "Type"    => "VARCHAR(200)",
              "Input"   => "text|width:400"],
            [ "Name"    => "debit_credit",
              "Type"    => "VARCHAR(1)",
              "Input"   => "select|D,C|width:80"],
            [ "Name"    => "category",
              "Type"    => "VARCHAR(200)",
              "Input"   => "text|datalist|account:category|width:400"]
        ];
        parent::__construct($tableName, $fields, true);
    }

}
