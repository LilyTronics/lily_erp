<?php

class ControllerHome extends ControllerApplication
{

    protected function showPage($parameters)
    {
        $view = $this->createView("viewHome");
        return $view->output();
    }

}
