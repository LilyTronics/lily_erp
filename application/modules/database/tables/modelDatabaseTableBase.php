<?php

class ModelDatabaseTableBase extends ModelDatabaseTable {

    public function __construct($tableName, $fields=null, $autoCreateTable=false, $defaultRecords=[]) {
        $config = new ModelConfiguration(CONFIG_FILE);
        $db = $config->getValue("sql", "database");
        $host = $config->getValue("sql", "host");
        $user = $config->getValue("sql", "user");
        $password = $config->getValue("sql", "password");

        parent::__construct($db, $tableName, $fields, $host, $user, $password, $autoCreateTable, $defaultRecords);
    }

    public static function GetModelForTable($tableName)
    {
        $table = null;
        switch ($tableName) {
            case "bank_transaction":
                $table = new ModelDatabaseTableBankTransaction();
                break;

            case "user":
                $table = new ModelDatabaseTableUser();
                break;
        }
        return $table;
    }

    public function getRecords($filterExpression="", $orderExpression="", $groupExpression="", $start=0, $count=0,
                               $fields=["*"], $join="", $joinTable="", $joinExpression="", $joinFields=["*"])
    {
        $records = $this->selectRecords($filterExpression, $orderExpression, $groupExpression, $start, $count,
                                        $fields, $join, $joinTable, $joinExpression, $joinFields);
        if (!$records[0])
        {
            DEBUG_LOG->writeMessage("Error getting records for table: {$this->tableName}");
            DEBUG_LOG->writeMessage($this->getError());
            return [];
        }
        return $records[1];
    }

}

?>
