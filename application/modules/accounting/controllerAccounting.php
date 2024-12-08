<?php

class ControllerAccounting extends ControllerApplication
{

    protected function showAccounting($parameters)
    {
        $pageData =[
            "sub_title" => "Accounting"
        ];
        return $this->showView("Accounting", $pageData);
    }

    /* Bank transactions */

    protected function showBank($parameters)
    {
        $table = new ModelDatabaseTableBankTransaction();
        $pageData = [
            "sub_title"  => "Bank transactions",
            "inputs"     => $table->inputs,
            "records"    => $table->getRecords(),
            "record_uri" => "accounting/bank/transaction/"

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
            "on_delete_uri"  => "accounting/bank",
            "on_failure_uri" => "accounting/bank/transaction/{$id}"
        ];

        return $this->showView("BankTransaction", $pageData);
    }

    /* Journal */

    protected function showJournal($parameters)
    {
        $table = new ModelDatabaseTableJournal();
        $pageData = [
            "sub_title" => "Journal",
            "records" => $table->getRecords(),
            "item_name" => "entry"
        ];
        return $this->showView("Journal", $pageData);
    }

    /* Chart of accounts */

    protected function showChartOfAccounts($parameters)
    {
        $expandTo = (isset($parameters["number"]) ? $parameters["number"] : "");
        $table = new ModelDatabaseTableAccount();
        $pageData = [
            "sub_title" => "Chart of accounts",
            "accounts"  => $table->getAccounts($expandTo)
        ];
        return $this->showView("ChartOfAccounts", $pageData);
    }

    protected function showAccount($parameters)
    {
        $id = (isset($parameters["id"]) ? $parameters["id"] : 0);
        $table = new ModelDatabaseTableAccount();
        $failUri = "accounting/chart-of-accounts/account/{$id}";
        if ($id > 0)
        {
            $record = $table->getRecordById($id);
            $successUri = "accounting/chart-of-accounts/account/{$id}";
            $deleteUri = "accounting/chart-of-accounts";
        }
        else
        {
            $record = $table->generateNewRecord();
            $successUri = "accounting/chart-of-accounts";
            $deleteUri = "";
        }
        $pageData = [
            "sub_title"      => "Account [{$id}]",
            "record"         => $record,
            "inputs"         => $table->inputs,
            "table"          => $table->tableName,
            "on_success_uri" => $successUri,
            "on_failure_uri" => $failUri,
            "on_delete_uri"  => $deleteUri
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
