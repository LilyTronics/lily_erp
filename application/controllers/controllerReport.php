<?php

class ControllerReport extends ControllerApplication
{

    protected function showReport($parameters)
    {
        if (!isset($parameters["name"]))
        {
            return $this->showDashboard([]);
        }
        $parts = explode("-", $parameters["name"]);
        if (count($parts) < 2)
        {
            return $this->showDashboard([]);
        }

        $pageData = [
            "menu" => ModelMenu::getMenuFor($parts[0])
        ];
        return $this->showPage("viewReport", $pageData);
    }

}
