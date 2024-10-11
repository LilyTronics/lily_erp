<?php

class ModelDatabaseTableBase extends ModelDatabaseTable {

    public function __construct($tableName, $fields) {
        $config = new ModelConfiguration(CONFIG_FILE);
        $db = $config->getValue("sql", "database");
        $host = $config->getValue("sql", "host");
        $user = $config->getValue("sql", "user");
        $password = $config->getValue("sql", "password");

        parent::__construct($db, $tableName, $fields, $host, $user, $password,
                            $autoCreateTable=true, $defaultRecords=[]);
    }

}

?>
