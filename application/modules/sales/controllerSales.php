<?php

class ControllerSales extends ControllerApplication
{

    protected function showSales($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("sales/viewSales", $pageData);
    }

}
