<?php

class ControllerAccounting extends ControllerApplication
{

    protected function showAccounting($parameters)
    {
        return $this->showView("Accounting");
    }

    /* Bank transactions */

    protected function showBank($parameters)
    {
        $table = new ModelDatabaseTableBankTransaction();
        $pageData = [
            "records" => $table->getRecords(),
            "record_uri" => "accounting/bank/transaction/",
        ];
        return $this->showView("Bank", $pageData);
    }

    protected function showBankTransaction($parameters)
    {
        $id = (isset($parameters["id"]) ? $parameters["id"] : 0);
        $table = new ModelDatabaseTableBankTransaction();
        $pageData = [
            "record" => $table->getRecordById($id),
            "table" => $table->tableName
        ];
        return $this->showView("BankTransaction", $pageData);
    }

    /* Journal */

    protected function showJournal($parameters)
    {
        return $this->showView("Journal");
    }

    /* Chart of accounts */

    protected function showChartOfAccounts($parameters)
    {
        return $this->showView("ChartOfAccounts");
    }

    protected function showAccount($parameters)
    {
        $id = (isset($parameters["id"]) ? $parameters["id"] : 0);
        $table = new ModelDatabaseTableAccount();
        $failUri = "chart-of-accounts/account/{$id}";
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
        return $this->showView("Report");
    }

    /* Show the view */

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelAccounting::getMenu();
        return $this->showPage("accounting/view{$pageName}", $pageData);
    }

}
