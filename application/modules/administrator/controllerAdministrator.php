<?php

class ControllerAdministrator extends ControllerApplication
{

    protected function showAdministrator($parameters)
    {
        $table = new ModelDatabaseTableSetting();
        $pageData = [
            "sub_title" => "Application settings",
            "settings"  => $table->getSettings()
        ];
        return $this->showView("Administrator", $pageData);
    }

    /* Log files */

    protected function showLogFiles($parameters)
    {
        $pageData = [
            "sub_title" => "Log files",
            "log_files" => ModelAdministrator::getLogFiles()
        ];
        if (isset($parameters["filename"]))
        {
            $pageData["sub_title"]    = "Log file {$parameters["filename"]}";
            $pageData["filename"]     = $parameters["filename"];
            $pageData["file_content"] = ModelAdministrator::getFileContent($parameters["filename"]);
        }
        return $this->showView("LogFiles", $pageData);
    }

    protected function deleteLogFile($parameters)
    {
        if (isset($parameters["filename"]))
        {
            ModelAdministrator::deleteLogFile($parameters["filename"]);
        }
        $this->gotoLocation("administrator/log-files");
    }

    /* Database */

    protected function showDatabase($parameters)
    {
        $pageData = [
            "sub_title" => "Database",
            "tables"    => ModelAdministrator::getTables(),
        ];
        $table = (isset($parameters["table"]) ? $parameters["table"] : "");
        $id = (isset($parameters["id"]) ? $parameters["id"] : null);
        if ($id !== null and $table != "")
        {
            $pageData["sub_title"] = "Record [{$id}] from {$table}";
            $pageData["record"] = ModelAdministrator::getRecord($table, $id);
            $pageData["inputs"] = ModelAdministrator::getInputs($table);
            $pageData["on_success_uri"] = REQUEST_URI;
            $pageData["on_failure_uri"] = REQUEST_URI;
            $pageData["on_delete_uri"] = "/administrator/database-table/{$table}";
        }
        elseif ($table != "")
        {
            $pageData["sub_title"] = "Records from {$table}";
            $pageData["records"] = ModelAdministrator::getRecords($table);
        }
        $pageData["table"] = $table;
        return $this->showView("Database", $pageData);
    }

    /* Show view */

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelAdministrator::getMenu();
        return $this->showPage("administrator/view{$pageName}", $pageData);
    }

}
