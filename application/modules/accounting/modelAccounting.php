<?php

class ModelAccounting
{

    public function getDashboard()
    {
        return [
            "order"   => 1,
            "title"   => "Accounting",
            "icon"    => "fa-solid fa-cash-register",
            "link"    => "accounting",
            "content" => "to do"
        ];
    }

    public static function getMenu()
    {
        return [
            ["Accounting", "accounting"],
            ["Bank transactions", "accounting/bank"],
            ["Journal", "accounting/journal"],
            ["Chart of Accounts", "accounting/chart-of-accounts"],
            ["Reports", [
                ["VAT", "accounting/reports/vat"],
            ]]
        ];
    }

}
