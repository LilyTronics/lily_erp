<?php

class ModelDatabaseTableBankTransaction extends ModelDatabaseTableBase {

    public function __construct() {
        $tableName = "bank_transaction";
        $fields = [
            ["Name"    => "id",
             "Type"    => "INT",
             "Options" => "AUTO_INCREMENT",
             "Key"     => true],
            ["Name"    => "reference",
             "Type"    => "VARCHAR(200)"],
            ["Name"    => "own_account",
             "Type"    => "VARCHAR(200)"],
            ["Name"    => "date",
             "Type"    => "DATE"],
            ["Name"    => "debit_credit",
             "Type"    => "VARCHAR(1)"],
            ["Name"    => "amount",
             "Type"    => "DECIMAL(18,5)"],
            ["Name"    => "transaction_type",
             "Type"    => "VARCHAR(200)"],
            ["Name"    => "counter_account",
             "Type"    => "VARCHAR(200)"],
            ["Name"    => "counter_name",
             "Type"    => "VARCHAR(200)"],
            ["Name"    => "description",
             "Type"    => "VARCHAR(200)"],
            ["Name"    => "state",
             "Type"    => "VARCHAR(200)"]
        ];
        parent::__construct($tableName, $fields, true);
    }

}
