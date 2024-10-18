<?php

class ControllerReport extends ControllerApplication
{

    protected function showReport($parameters)
    {
        $parts = explode("-", $parameters["name"]);
        $pageData = [
            "menu" => ModelMenu::getMenuFor($parts[0])
        ];
        return $this->showPage("viewReport", $pageData);
    }

}
