<?php

class ModelDatabaseTableBankTransaction extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "bank_transaction";

        $this->fields[] = [ "Name" => "reference",        "Type" => "VARCHAR(200)"  ];
        $this->fields[] = [ "Name" => "own_account",      "Type" => "VARCHAR(200)"  ];
        $this->fields[] = [ "Name" => "date",             "Type" => "DATE"          ];
        $this->fields[] = [ "Name" => "debit_credit",     "Type" => "VARCHAR(1)"    ];
        $this->fields[] = [ "Name" => "amount",           "Type" => "DECIMAL(18,5)" ];
        $this->fields[] = [ "Name" => "transaction_type", "Type" => "VARCHAR(200)"  ];
        $this->fields[] = [ "Name" => "counter_account",  "Type" => "VARCHAR(200)"  ];
        $this->fields[] = [ "Name" => "counter_name",     "Type" => "VARCHAR(200)"  ];
        $this->fields[] = [ "Name" => "description",      "Type" => "VARCHAR(200)"  ];
        $this->fields[] = [ "Name" => "state",            "Type" => "VARCHAR(200)"  ];

        // $this->inputs["field_name"] = ["type" => "text"];

        parent::__construct(true);
    }

}
