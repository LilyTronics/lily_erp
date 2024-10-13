<?php

class ControllerShowPage extends ControllerApplication
{

    protected function showLogIn($parameters)
    {
        return $this->showPage("LogIn");
    }

    protected function showDashboard($parameters)
    {
        return $this->showPage("Dashboard");
    }

    private function showPage($pageName)
    {
        $view = $this->createView("view$pageName");
        return $view->output();
    }

}
