<?php

class ModelDatabaseTableAccount extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "account";

        $this->fields[] = [ "name" => "parent_id",    "type" => "INT"         , "required" => true  ];
        $this->fields[] = [ "name" => "number",       "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "name",         "type" => "VARCHAR(200)", "required" => true  ];
        $this->fields[] = [ "name" => "debit_credit", "type" => "VARCHAR(1)"  , "required" => true  ];
        $this->fields[] = [ "name" => "category",     "type" => "VARCHAR(200)", "required" => false ];

        $this->inputs["parent_id"]    = ["type" => "text", "width" => "small"];
        $this->inputs["number"]       = ["type" => "text", "width" => "small"];
        $this->inputs["name"]         = ["type" => "text"];
        $this->inputs["debit_credit"] = ["type" => "select", "data" => ["D", "C"] ];
        $this->inputs["category"]     = ["type" => "text"];

        parent::__construct(true);
    }

}
