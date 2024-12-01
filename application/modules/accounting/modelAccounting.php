<?php

class ModelAccounting
{

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

    public function getDashboard()
    {
        return [
            "order"   => 7,
            "title"   => "Accounting",
            "icon"    => "fa-solid fa-cash-register",
            "link"    => "accounting",
            "content" => $this->getDashboardContent()
        ];
    }

    private function getDashboardContent() {
        return [
            ["{ICON_EXCLAMATION}", "3 open bank transactions require attention"],
            ["{ICON_CHECK_OK}",    "the balance sheet looks good"]
        ];
    }

}
