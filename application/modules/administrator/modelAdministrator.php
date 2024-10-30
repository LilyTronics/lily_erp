<?php

class ModelAdministrator
{

    public static function getMenu()
    {
        return [
            ["Administrator", "administrator"],
            ["Log files", "administrator/log-files"],
            ["Database", "adminstrator/database"]
        ];
    }

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
}
