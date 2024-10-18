<?php

class ControllerUsers extends ControllerApplication
{

    protected function showUsers($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewUsers", $pageData);
    }

    protected function showMyAccount($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewMyAccount", $pageData);
    }

}
