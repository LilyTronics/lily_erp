<?php

class ControllerAdministrator extends ControllerApplication
{

    protected function showAdministrator($parameters)
    {
        return $this->showView("Administrator");
    }

    /* Log files */

    protected function showLogFiles($parameters)
    {
        $pageData = [
            "LogFiles" => ModelAdministrator::getLogFiles()
        ];
        if (isset($parameters["filename"]))
        {
            $pageData["Content"] = [
                "Filename"    => $parameters["filename"],
                "FileContent" => ModelAdministrator::getFileContent($parameters["filename"])
            ];
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
            "tables" => ModelAdministrator::getTables()
        ];
        if (isset($parameters["table"]))
        {
            $pageData["content"] = [
                "table"   => $parameters["table"],
                "records" => ModelAdministrator::getRecords($parameters["table"])
            ];
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