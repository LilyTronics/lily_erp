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
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("Report", $pageData);
    }


    /* Accounting pages */

    protected function showAccounting($parameters)
    {
        $pageData = [
            "menu" => [
                ["Bank", "accounting/bank"],
                ["Reports", [
                    ["VAT", "accounting/reports/accounting-vat"],
                ]]
            ]
        ];
        return $this->showPage("Accounting", $pageData);
    }

    protected function showBank($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("Bank", $pageData);
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

    private function showPage($pageName, $pageData=null)
    {
        if ($pageData !== null)
        {
            $pageData["page_name"] = $pageName;
        }
        $view = $this->createView("view$pageName");
        $view->setUserData("page_data", $pageData);
        return $view->output();
    }

}
