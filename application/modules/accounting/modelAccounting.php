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
        $messages = [];
        $table = new ModelDatabaseTableBankTransaction();
        $records = $table->getRecords("state = 'open'");
        if (count($records) == 0)
        {
            $messages[] = [
                "icon"    => "{ICON_CHECK_OK}",
                "message" => "No open bank transactions",
                "link"    => ""];
        }
        else
        {
            $messages[] = [
                "icon"    => "{ICON_EXCLAMATION}",
                "message" => count($records) . " bank transactions require attention",
                "link"    => "accounting/bank"
            ];
        }
        return $messages;
    }

}
