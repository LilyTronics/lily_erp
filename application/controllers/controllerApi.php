<?php

class ControllerApi extends ControllerApplication
{

    protected $DEFAULT_RESULT = ["result" => false, "message" => "Server error, try again later."];


    protected function processApiCall($parameters)
    {
        $result = $this->DEFAULT_RESULT;

        return json_encode($result, JSON_PRETTY_PRINT);
    }

}
