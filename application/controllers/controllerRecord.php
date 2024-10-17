<?php

class ControllerRecord extends ControllerApplication
{

    protected function showRecord($parameters)
    {
        return $this->showPage("Record");
    }

    private function showPage($pageName)
    {
        $view = $this->createView("view$pageName");
        return $view->output();
    }

}
