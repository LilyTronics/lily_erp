<?php

class ControllerAccounting extends ControllerApplication
{

    protected function showAccounting($parameters)
    {
        $pageData =[
            "sub_title"   => "Accounting",
            "assets"      => ModelAccounting::getAccountsForBalance("assets"),
            "liabilities" => ModelAccounting::getAccountsForBalance("liabilities"),
            "equity"      => ModelAccounting::getAccountsForBalance("equity")
        ];
        return $this->showView("Accounting", $pageData);
    }

    /* Bank transactions */

    protected function showBank($parameters)
    {
        $table = new ModelDatabaseTableBankTransaction();
        $pageData = [
            "sub_title"         => "Bank transactions",
            "inputs"            => $table->inputs,
            "records"           => $table->getRecords(),
            "record_uri"        => "accounting/bank/transaction/",
            "open_transactions" => $table->getRecords("state = 'open'")
        ];
        return $this->showView("Bank", $pageData);
    }

    protected function showBankTransaction($parameters)
    {
        $id = (isset($parameters["id"]) ? $parameters["id"] : 0);
        $table = new ModelDatabaseTableBankTransaction();
        $pageData = [
            "sub_title"      => "Bank transaction [{$id}]",
            "record"         => $table->getRecordById($id),
            "table"          => $table->tableName,
            "inputs"         => $table->inputs,
            "on_success_uri" => "accounting/bank/transaction/{$id}",
            "on_failure_uri" => "accounting/bank/transaction/{$id}",
            "on_delete_uri"  => "accounting/bank"
        ];
        return $this->showView("BankTransaction", $pageData);
    }

    /* Journal */

    protected function showJournal($parameters)
    {
        $table = new ModelDatabaseTableJournal();
        $pageData = [
            "sub_title"      => "Journal",
            "inputs"         => $table->inputs,
            "records"        => $table->getRecords(),
            "record_uri"     => "accounting/journal/entry/",
            "item_name"      => "entry",
            "table"          => $table->tableName,
            "on_success_uri" => REQUEST_URI,
            "on_failure_uri" => REQUEST_URI
        ];
        return $this->showView("Journal", $pageData);
    }

    protected function showJournalEntry($parameters)
    {
        $id = (isset($parameters["id"]) ? $parameters["id"] : 0);
        $table = new ModelDatabaseTableJournal();
        $pageData = [
            "sub_title"      => "Journal entry [{$id}]",
            "record"         => $table->getRecordById($id),
            "table"          => $table->tableName,
            "inputs"         => $table->inputs,
            "on_delete_uri"  => "accounting/journal",
            "on_success_uri" => "accounting/journal/entry/{$id}",
            "on_failure_uri" => "accounting/journal/entry/{$id}"
        ];
        return $this->showView("JournalEntry", $pageData);
    }

    /* Chart of accounts */

    protected function showChartOfAccounts($parameters)
    {
        $table = new ModelDatabaseTableAccount();
        $pageData = [
            "sub_title"     => "Chart of accounts",
            "records"        => $table->getRecords(),
            "inputs"         => $table->inputs,
            "record_uri"     => "accounting/chart-of-accounts/account/",
            "item_name"      => "account",
            "table"          => $table->tableName,
            "on_success_uri" => REQUEST_URI,
            "on_failure_uri" => REQUEST_URI

        ];
        return $this->showView("ChartOfAccounts", $pageData);
    }

    protected function showAccount($parameters)
    {
        $id = (isset($parameters["id"]) ? $parameters["id"] : 0);
        $table = new ModelDatabaseTableAccount();
        $pageData = [
            "sub_title"      => "Account [{$id}]",
            "record"         => $table->getRecordById($id),
            "table"          => $table->tableName,
            "inputs"         => $table->inputs,
            "on_delete_uri"  => "accounting/chart-of-accounts",
            "on_success_uri" => "accounting/chart-of-accounts/account/{$id}",
            "on_failure_uri" => "accounting/chart-of-accounts/account/{$id}"
        ];
        return $this->showView("Account", $pageData);
    }


    /* Reports */

    protected function showReport($parameters)
    {
        $pageData = [
            "sub_title" => "Report <name>"
        ];
        return $this->showView("Report", $pageData);
    }

    /* Show the view */

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelAccounting::getMenu();
        return $this->showPage("accounting/view{$pageName}", $pageData);
    }

}
