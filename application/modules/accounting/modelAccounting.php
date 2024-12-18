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

    public static function getAccountsForBalance($category)
    {
        $records = [];
        $account = new ModelDatabaseTableAccount();
        $journal = new ModelDatabaseTableJournal();
        $mainAccounts = $account->getMainAccountsFor($category);
        foreach ($mainAccounts as $mainAccount)
        {
            $filter = substr($mainAccount["number"], 0, 2) . "%";
            $record = [
                "name" => "{$mainAccount["number"]} - {$mainAccount["name"]}",
                "amount" => self::calculateTotalForAccounts("number LIKE '{$filter}'")
            ];
            $records[] = $record;
        }
        if ($category == "equity")
        {
            $income = self::calculateTotalForAccounts("category = 'income'");
            $costs = self::calculateTotalForAccounts("category = 'expenses'");
            $records[] = ["name" => "Result", "amount" => ($income - $costs)];
        }
        return $records;
    }

    private static function calculateTotalForAccounts($accountFilter)
    {
        $total = 0;
        $account = new ModelDatabaseTableAccount();
        $journal = new ModelDatabaseTableJournal();
        $records = $account->getRecords($accountFilter);
        foreach ($records as $record)
        {
            $fields = ["COALESCE(SUM(debit), 0) as total_debit", "COALESCE(SUM(credit), 0) as total_credit"];
            if ($record["debit_credit"] == "D")
            {
                $fields[] = "(COALESCE(SUM(debit), 0) - COALESCE(SUM(credit), 0)) as result";
            }
            else
            {
                $fields[] = "(COALESCE(SUM(credit), 0) - COALESCE(SUM(debit), 0)) as result";
            }
            $result = $journal->getRecords("account_id = {$record["id"]}", fields:$fields);
            $total += $result[0]["result"];
        }
        return $total;
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
            $icon = "{ICON_CHECK_OK}";
            $message = "No open bank transactions";
        }
        else
        {
            $icon = "{ICON_EXCLAMATION}";
            $message = count($records) . " bank transactions require attention";
        }
        $messages[] = [
            "icon"    => $icon,
            "message" => $message,
            "link"    => "accounting/bank"
        ];
        // Check balance
        $assets = $this->calculateTotalForAccounts("category = 'assets'");
        $liabilities = $this->calculateTotalForAccounts("category = 'liabilities'");
        $equity = $this->calculateTotalForAccounts("category = 'equity'");
        $income = $this->calculateTotalForAccounts("category = 'income'");
        $costs = $this->calculateTotalForAccounts("category = 'expenses'");
        // Balance must be 0
        $balance = round($assets - $liabilities - $equity - $income + $costs, DECIMAL_PRECISION);
        if ($balance != 0)
        {
            $icon = "{ICON_EXCLAMATION}";
            $message = "Your balance sheet needs attention";
        }
        else
        {
            $icon = "{ICON_CHECK_OK}";
            $message = "Your balance sheet looks good";
        }
        $messages[] = [
            "icon"    => $icon,
            "message" => $message,
            "link"    => "accounting"
        ];
        return $messages;
    }

}
