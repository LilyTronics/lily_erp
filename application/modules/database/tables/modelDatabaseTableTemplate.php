<?php

class ModelDatabaseTableTemplate extends ModelDatabaseTableBase {

    public function __construct() {
        $tableName = "template";
        $fields = [
            [ "Name"    => "id",
              "Type"    => "INT",
              "Options" => "AUTO_INCREMENT",
              "Key"     => true ]
        ];
        parent::__construct($tableName, $fields, true);
    }

}
