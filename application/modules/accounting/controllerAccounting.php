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
