<?php

class ModelDatabaseTableBankTransaction extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "bank_transaction";

        $this->fields[] = ["name" => "reference",        "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "own_account",      "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "date",             "type" => "DATE",             "required" => true];
        $this->fields[] = ["name" => "debit_credit",     "type" => "VARCHAR(1)",       "required" => true];
        $this->fields[] = ["name" => "amount",           "type" => self::TYPE_DECIMAL, "required" => true];
        $this->fields[] = ["name" => "transaction_type", "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "counter_account",  "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "counter_name",     "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "description",      "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "state",            "type" => "VARCHAR(200)",     "required" => true];

        foreach ($this->fields as $field)
        {
            $this->inputs[$field["name"]] = [];
        }

        parent::__construct(true);
    }

}
