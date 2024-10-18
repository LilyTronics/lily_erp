<?php

class ControllerShowPage extends ControllerApplication
{

    /* Generic pages */

    protected function showLogIn($parameters)
    {
        return $this->showPage("viewLogIn");
    }

    protected function showDashboard($parameters)
    {
        $pageData = [
            "items" => ModelDashboard::getDashboardItems()
        ];
        return $this->showPage("viewDashboard", $pageData);
    }


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


    /* Inventory pages */

    protected function showInventory($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewInventory", $pageData);
    }


    /* Product pages */

    protected function showProducts($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewProducts", $pageData);
    }


    /* Purchase pages */

    protected function showPurchase($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewPurchase", $pageData);
    }


    /* Relation pages */

    protected function showRelations($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewRelations", $pageData);
    }


    /* Sales pages */

    protected function showSales($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewSales", $pageData);
    }


    /* User pages */

    protected function showUsers($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewUsers", $pageData);
    }


    /* Show the  page */

    protected function showPage($pageName, $pageData=null)
    {
        $view = $this->createView($pageName);
        $view->setUserData("page_data", $pageData);
        return $view->output();
    }

}
