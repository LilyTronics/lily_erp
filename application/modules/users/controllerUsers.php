<?php

class ControllerUsers extends ControllerApplication
{

    protected function showUsers($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("users/viewUsers", $pageData);
    }

    protected function showMyAccount($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("users/viewMyAccount", $pageData);
    }

}
