<?php

class ModelDatabaseTableBankTransaction extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "bank_transaction";

        $this->fields[] = [ "name" => "reference",        "type" => "VARCHAR(200)"     ];
        $this->fields[] = [ "name" => "own_account",      "type" => "VARCHAR(200)"     ];
        $this->fields[] = [ "name" => "date",             "type" => "DATE"             ];
        $this->fields[] = [ "name" => "debit_credit",     "type" => "VARCHAR(1)"       ];
        $this->fields[] = [ "name" => "amount",           "type" => self::TYPE_DECIMAL ];
        $this->fields[] = [ "name" => "transaction_type", "type" => "VARCHAR(200)"     ];
        $this->fields[] = [ "name" => "counter_account",  "type" => "VARCHAR(200)"     ];
        $this->fields[] = [ "name" => "counter_name",     "type" => "VARCHAR(200)"     ];
        $this->fields[] = [ "name" => "description",      "type" => "VARCHAR(200)"     ];
        $this->fields[] = [ "name" => "state",            "type" => "VARCHAR(200)"     ];

        parent::__construct(true);
    }

}
