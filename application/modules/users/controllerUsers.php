<?php

class ControllerUsers extends ControllerApplication
{

    protected function showUsers($parameters)
    {
        $pageData = [];
        return $this->showView("Users", $pageData);
    }

    protected function showMyAccount($parameters)
    {
        $pageData = [];
        return $this->showView("MyAccount", $pageData);
    }

    /* Show the view */

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelUsers::getMenu();
        return $this->showPage("users/view{$pageName}", $pageData);
    }

}
