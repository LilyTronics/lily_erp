<?php

class ModelDatabaseTableTemplate extends ModelDatabaseTableBase
{

    public function __construct()
    {
        $this->tableName = "template";

        // $this->fields[] = [ "name" => "field_name", "type" => "field_type", "required" => true ];

        // $this->inputs["field_name"] = ["type" => "text"];

        parent::__construct(true);
    }

}
