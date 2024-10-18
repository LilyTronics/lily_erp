<?php

class ModelDashboard
{

    private static $dashboardItems = [
        [ "fa-cash-register",       "Accounting",   "accounting",   "" ],
        [ "fa-address-card",        "Relations",    "relations",    "" ],
        [ "fa-shop",                "Sales",        "sales",        "" ],
        [ "fa-basket-shopping",     "Purchase",     "purchase",     "" ],
        [ "fa-warehouse",           "Inventory",    "inventory",    "" ],
        [ "fa-boxes-stacked",       "Products",     "products",     "" ],
        [ "fa-users",               "Users",        "users",        "" ]
    ];


    public static function getDashboardItems()
    {
        $items = [];
        foreach (self::$dashboardItems as $item)
        {
            $newItem = [
                "title"   => "<i class=\"fa-solid {$item[0]} w3-margin-right\"></i>{$item[1]}",
                "uri"     => WEB_ROOT . $item[2],
                "content" => $item[3]
            ];
            $items[] = $newItem;
        }

        return $items;
    }

}
