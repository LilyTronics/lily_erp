<?php

class ModelDatabaseTableTemplate extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "template";

        // $this->fields[] = [ "Name" => "field_name", "Type" => "field_type", "Required" => true ];

        // $this->inputs["field_name"] = ["type" => "text"];

        parent::__construct(true);
    }

}
