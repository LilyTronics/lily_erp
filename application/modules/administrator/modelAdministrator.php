<?php

class ModelAdministrator
{

    public function getDashboard()
    {
        return [
            "order"   => 99,
            "title"   => "Administrator",
            "icon"    => "fa-solid fa-screwdriver-wrench",
            "link"    => "administrator",
            "content" => $this->getDashboardContent()
        ];
    }

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
        return "";
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
        // Make sure all tables are created
        ModelDatabaseTableBase::createTables();

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
        $table = ModelDatabaseTableBase::getModelForTable($table);
        return $table->getRecords();
    }

    public static function getRecord($table, $id)
    {
        $table = ModelDatabaseTableBase::getModelForTable($table);
        $record = $table->generateNewRecord();
        $records = $table->getRecords("id = $id");
        if (count($records) == 1) {
            $record = $records[0];
        }
        return $record;
    }

    public static function getInputs($table)
    {
        $table = ModelDatabaseTableBase::getModelForTable($table);
        return ($table != null ? $table->inputs : []);
    }

    private static function getDashboardContent() {
        $messages = [];
        $errors = self::getFileContent("errorHandler");
        if ($errors == "")
        {
            $messages[] = [
                "icon"    => "{ICON_CHECK_OK}",
                "message" => "No errors in the log file",
                "link"    => "administrator/log-files"
            ];
        }
        else
        {
            $messages[] = [
                "icon"    => "{ICON_EXCLAMATION}",
                "message" => "There are error messages in the log file",
                "link"    => "administrator/log-file/errorHandler"
            ];
        }
        return $messages;
    }

}
