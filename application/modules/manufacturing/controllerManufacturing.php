<?php

class ControllerManufacturing extends ControllerApplication
{

    protected function showManufacturing($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("manufacturing/viewManufacturing", $pageData);
    }

}
