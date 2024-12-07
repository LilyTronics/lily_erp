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
        $table = (isset($parameters["table"]) ? $parameters["table"] : "");
        $id = (isset($parameters["id"]) ? $parameters["id"] : null);
        $mode = "database";
        if ($table != "")
        {
            $mode = "table";
        }
        if ($id !== null)
        {
            $mode = "record";
        }

        $pageData = [
            "mode"           => $mode,
            "sub_title"      => "Database",
            "tables"         => ModelAdministrator::getTables(),
            "table"          => $table,
            "inputs"         => ModelAdministrator::getInputs($table),
            "on_success_uri" => REQUEST_URI,
            "on_failure_uri" => REQUEST_URI
        ];
        if ($mode == "table")
        {
            $pageData["sub_title"]  = "Records from {$table}";
            $pageData["record_uri"] = "administrator/database-record/{$table}/";
            $pageData["item_name"]  = "record";
            $pageData["records"]    = ModelAdministrator::getRecords($table);
        }
        if ($mode == "record")
        {
            $pageData["sub_title"]     = "Record [{$id}] from {$table}";
            $pageData["record"]        = ModelAdministrator::getRecord($table, $id);
            $pageData["on_delete_uri"] = "/administrator/database-table/{$table}";
        }
        return $this->showView("Database", $pageData);
    }

    /* Show view */

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelAdministrator::getMenu();
        return $this->showPage("administrator/view{$pageName}", $pageData);
    }

}
