<?php

class ControllerShowPage extends ControllerApplication
{

    protected function showLogIn($parameters)
    {
        return $this->showPage("LogIn");
    }

    protected function showDashboard($parameters)
    {
        $pageData = [
            "items" => [
                [
                    "title"   => "<i class=\"fa-solid fa-cash-register w3-margin-right\"></i>Accounting",
                    "uri"     => WEB_ROOT . "accounting",
                    "content" => "some accounting stuff"
                ],
                [
                    "title"   => "<i class=\"fa-solid fa-address-card w3-margin-right\"></i>Relations",
                    "uri"     => WEB_ROOT . "relations",
                    "content" => "some relations stuff"
                ],
                [
                    "title"   => "<i class=\"fa-solid fa-shop w3-margin-right\"></i>Sales",
                    "uri"     => WEB_ROOT . "sales",
                    "content" => "some sales stuff"
                ],
                [
                    "title"   => "<i class=\"fa-solid fa-basket-shopping w3-margin-right\"></i>Purchase",
                    "uri"     => WEB_ROOT . "purchase",
                    "content" => "some purchase stuff"
                ],
                [
                    "title"   => "<i class=\"fa-solid fa-warehouse w3-margin-right\"></i>Inventory",
                    "uri"     => WEB_ROOT . "inventory",
                    "content" => "some inventory stuff"
                ],
                [
                    "title"   => "<i class=\"fa-solid fa-boxes-stacked w3-margin-right\"></i>Products",
                    "uri"     => WEB_ROOT . "products",
                    "content" => "some products stuff"
                ],
                [
                    "title"   => "<i class=\"fa-solid fa-users w3-margin-right\"></i>Users",
                    "uri"     => WEB_ROOT . "users",
                    "content" => "some users stuff"
                ]
            ]
        ];
        return $this->showPage("Dashboard", $pageData);
    }

    protected function showAccounting($parameters)
    {
        $pageData = [
            "menu" => [
                ["Bank", "accounting/bank"],
                ["Reports", [
                    ["VAT", "accounting/reports/vat"],
                ]]
            ]
        ];
        return $this->showPage("Accounting", $pageData);
    }

    protected function showInventory($parameters)
    {
        return $this->showPage("Inventory");
    }

    protected function showProducts($parameters)
    {
        return $this->showPage("Products");
    }

    protected function showPurchase($parameters)
    {
        return $this->showPage("Purchase");
    }

    protected function showRelations($parameters)
    {
        return $this->showPage("Relations");
    }

    protected function showSales($parameters)
    {
        return $this->showPage("Sales");
    }

    protected function showUsers($parameters)
    {
        return $this->showPage("Users");
    }

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
