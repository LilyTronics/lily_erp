<?php

class ControllerShowPage extends ControllerApplication
{

    /* Generic pages */

    protected function showLogIn($parameters)
    {
        return $this->showPage("LogIn");
    }

    protected function showDashboard($parameters)
    {
        $pageData = [
            "items" => ModelDashboard::getDashboardItems()
        ];
        return $this->showPage("Dashboard", $pageData);
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
        return $this->showPage("Report", $pageData);
    }


    /* Inventory pages */

    protected function showInventory($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("Inventory", $pageData);
    }


    /* Product pages */

    protected function showProducts($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("Products", $pageData);
    }


    /* Purchase pages */

    protected function showPurchase($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("Purchase", $pageData);
    }


    /* Relation pages */

    protected function showRelations($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("Relations", $pageData);
    }


    /* Sales pages */

    protected function showSales($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("Sales", $pageData);
    }


    /* User pages */

    protected function showUsers($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("Users", $pageData);
    }


    /* Show the  page */

    protected function showPage($pageName, $pageData=null)
    {
        $view = $this->createView("view$pageName");
        $view->setUserData("page_data", $pageData);
        return $view->output();
    }

}
