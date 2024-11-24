<?php

class ControllerAccounting extends ControllerApplication
{

    protected function showAccounting($parameters)
    {
        return $this->showView("Accounting");
    }

    protected function showBank($parameters)
    {
        $pageData = [];
        return $this->showView("Bank", $pageData);
    }

    protected function showJournal($parameters)
    {
        return $this->showView("Journal");
    }

    protected function showChartOfAccounts($parameters)
    {
        return $this->showView("ChartOfAccounts");
    }

    protected function showReport($parameters)
    {
        return $this->showView("Report");
    }

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelAccounting::getMenu();
        return $this->showPage("accounting/view{$pageName}", $pageData);
    }

}
