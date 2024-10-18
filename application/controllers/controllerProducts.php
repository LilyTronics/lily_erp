<?php

class ControllerProducts extends ControllerApplication
{

    protected function showProducts($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("products/viewProducts", $pageData);
    }

}
