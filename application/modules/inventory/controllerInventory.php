<?php

class ControllerInventory extends ControllerApplication
{

    protected function showInventory($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("inventory/viewInventory", $pageData);
    }

}
