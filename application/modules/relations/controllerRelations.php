<?php

class ControllerRelations extends ControllerApplication
{

    protected function showRelations($parameters)
    {
        $pageData = [
            "menu" => []
        ];
        return $this->showPage("relations/viewRelations", $pageData);
    }

}
