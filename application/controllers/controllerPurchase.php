<?php

class ControllerPurchase extends ControllerApplication
{

    protected function showPurchase($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewPurchase", $pageData);
    }

}
