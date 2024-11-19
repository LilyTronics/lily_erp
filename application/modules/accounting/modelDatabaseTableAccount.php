<?php

class ModelDatabaseTableAccount extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "account";

        $this->fields[] = [ "Name" => "parent_id",    "Type" => "INT"         , "Required" => true  ];
        $this->fields[] = [ "Name" => "number",       "Type" => "VARCHAR(200)", "Required" => true  ];
        $this->fields[] = [ "Name" => "name",         "Type" => "VARCHAR(200)", "Required" => true  ];
        $this->fields[] = [ "Name" => "debit_credit", "Type" => "VARCHAR(1)"  , "Required" => true  ];
        $this->fields[] = [ "Name" => "category",     "Type" => "VARCHAR(200)", "Required" => false ];

        // $this->inputs["field_name"] = ["type" => "text"];

        parent::__construct(true);
    }

}
