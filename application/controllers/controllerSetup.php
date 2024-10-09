<?php

class ControllerSetup extends ControllerApplication
{

    protected function showCreateConfig($parameters)
    {
        return $this->showPage("CreateConfig");
    }

    private function showPage($pageName)
    {
        $view = $this->createView("view$pageName");
        return $view->output();
    }

}
