<?php

class ModelDatabaseTableAccount extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "account";

        $this->fields[] = [ "Name" => "parent_id",    "Type" => "INT"          ];
        $this->fields[] = [ "Name" => "level",        "Type" => "INT"          ];
        $this->fields[] = [ "Name" => "number",       "Type" => "VARCHAR(200)" ];
        $this->fields[] = [ "Name" => "name",         "Type" => "VARCHAR(200)" ];
        $this->fields[] = [ "Name" => "debit_credit", "Type" => "VARCHAR(1)"   ];
        $this->fields[] = [ "Name" => "category",     "Type" => "VARCHAR(200)" ];

        // $this->inputs["field_name"] = ["type" => "text"];

        parent::__construct(true);
    }

}
