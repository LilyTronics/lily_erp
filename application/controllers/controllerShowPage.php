<?php

class ControllerShowPage extends ControllerApplication
{

    protected function showLogIn($parameters)
    {
        return $this->showPage("LogIn");
    }

    private function showPage($pageName)
    {
        $view = $this->createView("view$pageName");
        return $view->output();
    }

}
