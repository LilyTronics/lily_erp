<?php

class ControllerAdministrator extends ControllerApplication
{

    protected function showAdministrator($parameters)
    {
        return $this->showView("Administrator");
    }

    protected function showLogFiles($parameters)
    {
        return $this->showView("LogFiles");
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
