<?php

class ControllerReport extends ControllerApplication
{

    protected function showReport($parameters)
    {
        $parts = explode("-", $parameters["name"]);
        $pageData = [
            "menu" => "Model{$parts[0]}"::getMenu()   // ModelMenu::getMenuFor($parts[0])
        ];
        return $this->showPage("reports/viewReport", $pageData);
    }

}
