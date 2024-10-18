<?php

class ControllerRecord extends ControllerApplication
{

    protected function showRecord($parameters)
    {
        $pageData = [];
        return $this->showPage("database/viewRecord", $pageData);
    }

}
