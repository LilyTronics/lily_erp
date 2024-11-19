<?php

class ModelDatabaseTableAccount extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "account";

        $this->fields[] = [ "name" => "parent_id",    "type" => "INT"         , "required" => true  ];
        $this->fields[] = [ "name" => "number",       "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "name",         "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "debit_credit", "type" => "VARCHAR(1)"  , "required" => true  ];
        $this->fields[] = [ "name" => "category",     "type" => "VARCHAR(200)", "required" => false ];

        // $this->inputs["field_name"] = ["type" => "text"];

        parent::__construct(true);
    }

}
