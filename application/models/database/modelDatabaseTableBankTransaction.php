<?php

class ModelDatabaseTableBankTransaction extends ModelDatabaseTableBase {

    public $lockMaxAttempts = 5;
    public $lockTimeout = 30;

    public function __construct() {
        $fields = [
            [ "Name"    => "id",
              "Type"    => "INT",
              "Options" => "AUTO_INCREMENT",
              "Key"     => true ],
            [ "Name"    => "reference",
              "Type"    => "VARCHAR(200)" ],
            [ "Name"    => "own_account",
              "Type"    => "VARCHAR(200)" ],
            [ "Name"    => "date",
              "Type"    => "DATE" ],
            [ "Name"    => "debit_credit",
              "Type"    => "VARCHAR(1)" ],
            [ "Name"    => "amount",
              "Type"    => "DECIMAL(18,5)" ],
            [ "Name"    => "transaction_type",
              "Type"    => "VARCHAR(200)"],
            [ "Name"    => "counter_account",
              "Type"    => "VARCHAR(200)"],
            [ "Name"    => "counter_name",
              "Type"    => "VARCHAR(200)"],
            [ "Name"    => "description",
              "Type"    => "VARCHAR(200)"],
            [ "Name"    => "State",
              "Type"    => "VARCHAR(200)"]
        ];
        parent::__construct("bank_transaction", $fields, true);
    }

}
