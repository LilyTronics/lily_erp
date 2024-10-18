<?php

class ControllerDashboard extends ControllerApplication
{

    protected function showDashboard($parameters)
    {
        $pageData = [
            "items" => ModelDashboard::getDashboardItems()
        ];
        return $this->showPage("dashboard/viewDashboard", $pageData);
    }

}
