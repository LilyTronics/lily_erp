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
                    $result = ModelSetup::createConfiguration($postedData);
                }

            }
            else {
                $result["message"] = "No action in the posted data";
            }
        }
        catch (Exception $e)
        {
            $result["message"] = "Server error:<br/>" . $e->getMessage();
        }
        return json_encode($result, JSON_PRETTY_PRINT);
    }

}
