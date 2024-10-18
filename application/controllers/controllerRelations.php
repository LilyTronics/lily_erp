<?php

class ControllerRelations extends ControllerApplication
{

    protected function showRelations($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("viewRelations", $pageData);
    }

}
