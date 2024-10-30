<?php

class ControllerAdministrator extends ControllerApplication
{

    protected function showAdministrator($parameters)
    {
        return $this->showView("Administrator");
    }

    protected function showLogFiles($parameters)
    {
        $pageData = [
            "LogFiles" => ModelAdministrator::getLogFiles()
        ];
        if (isset($parameters["filename"]))
        {
            $pageData["Content"] = [
                "Filename"    => strtolower(preg_replace("([A-Z])", " $0", $parameters["filename"])),
                "FileContent" => ModelAdministrator::getFileContent($parameters["filename"])
            ];
        }
        return $this->showView("LogFiles", $pageData);
    }

    protected function showDatabase($parameters)
    {
        return $this->showView("Database");
    }

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelAdministrator::getMenu();
        return $this->showPage("administrator/view{$pageName}", $pageData);
    }

}
