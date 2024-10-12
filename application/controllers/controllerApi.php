<?php

class ControllerApi extends ControllerApplication
{

    protected $DEFAULT_RESULT = ["result" => false, "message" => "Server error, try again later."];


    protected function processApiCall($parameters)
    {
        $result = $this->DEFAULT_RESULT;
        try
        {
            $postedData = ModelHelper::getPostedData(true);
            if (isset($postedData["action"]))
            {
                // Special actions
                if ($postedData["action"] == "create_configuration")
                {
                    if (isset($postedData["record"]))
                    {
                        $result = ModelSetup::createConfiguration($postedData["record"], $result);
                    }
                }
                if ($postedData["action"] == "log_in")
                {
                    if (isset($postedData["record"]))
                    {
                        $result = ModelApplicationSession::createSession($postedData["record"], $result);
                    }
                }
            }
        }
        catch (Exception $e)
        {
            $result["message"] = "Server error:<br/>" . $e->getMessage();
        }
        return json_encode($result, JSON_PRETTY_PRINT);
    }

}
