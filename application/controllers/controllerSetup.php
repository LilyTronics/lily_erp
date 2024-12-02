<?php

class ControllerSetup extends ControllerApplication
{

    protected function showCreateConfig($parameters)
    {
        $pageData = [
            "sub_title" => "Create configuration"
        ];
        return $this->showPage("viewCreateConfig", $pageData);
    }

}
