<?php

class ControllerSetup extends ControllerApplication
{

    protected function showCreateConfig($parameters)
    {
        return $this->showPage("viewCreateConfig");
    }

}
