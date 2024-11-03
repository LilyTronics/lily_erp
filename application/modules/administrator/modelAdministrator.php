<?php

class ModelAdministrator
{

    public static function getMenu()
    {
        return [
            ["Administrator", "administrator"          ],
            ["Log files",     "administrator/log-files"],
            ["Database",      "administrator/database" ]
        ];
    }

    /* log files */

    public static function getLogFiles()
    {
        $logFiles = [];
        foreach (glob(SYS_LOG_PATH . "*.log") as $filename)
        {
            $parts = explode(".", basename($filename));
            $logFiles[] = $parts[0];
        }
        return $logFiles;
    }

    public static function getFileContent($filename)
    {
        $filename = SYS_LOG_PATH . "{$filename}.log";
        if (file_exists($filename)) {
            return file_get_contents($filename);
        }
        return "The file does not exist";
    }

    public static function deleteLogFile($filename)
    {
        $filename = SYS_LOG_PATH . "{$filename}.log";
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    /* database */

    public static function getTables()
    {
        $tables = [];
        $table = new ModelDatabaseTableBase();
        $result = $table->selectRecordsFromQuery("SHOW TABLES FROM {$table->database}");
        if ($result[0])
        {
            $tables = array_map(fn($x) : string => array_values($x)[0], $result[1]);
        }
        return $tables;
    }

    public static function getRecords($table)
    {
        $records = [];
        $table = ModelDatabaseTableBase::GetModelForTable($table);
        $result = $table->selectRecords();
        if ($result[0])
        {
           $records = $result[1];
        }
        return $records;
    }

}
