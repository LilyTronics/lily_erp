<?php

class ModelDatabaseTableAccounts extends ModelDatabaseTableBase {

    public function __construct() {
        $tableName = "accounts";
        $fields = [
            [ "Name"    => "id",
              "Type"    => "INT",
              "Options" => "AUTO_INCREMENT",
              "Key"     => true ]
        ];
        parent::__construct($tableName, $fields, true);
    }

}
