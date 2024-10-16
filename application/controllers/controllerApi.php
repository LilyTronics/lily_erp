<?php

class ControllerApi extends ControllerApplication
{

    protected function processApiCall($parameters)
    {
        $result = ["result" => false, "message" => "Server error, try again later."];
        $postedData = ModelHelper::getPostedData(true);

        $action = "";
        if (isset($postedData["action"]))
        {
            $action = $postedData["action"];
        }
        $result["debug"] = $action;

        if (ModelApplicationSession::checkSession() || $action == "log_in" || $action == "log_out") {
            $result = $this->getResultFromApiCall($postedData, $result);
        }
        else
        {
            $result["message"] = "Unauthorized";
        }
        return json_encode($result, JSON_PRETTY_PRINT);
    }

    private function getResultFromApiCall($postedData, $result)
    {
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
                elseif ($postedData["action"] == "log_in")
                {
                    if (isset($postedData["record"]))
                    {
                        $result = ModelApplicationSession::createSession($postedData["record"], $result);
                    }
                }
                elseif (ModelHelper::startsWith($postedData["action"], "get_"))
                {
                    $parts = explode("_", $postedData["action"], 2);
                    if (count($parts) == 2) {
                        $result = $this->processDataFromDatabase($parts[0], $parts[1]);
                    }
                    else
                    {
                        $result["message"] = "Invalid action '{$postedData["action"]}'";
                    }
                }
                else
                {
                    $result["message"] = "Unknown action '{$postedData["action"]}'";
                }
            }
            else
            {
                $result["message"] = "No action defined";
            }
        }
        catch (Exception $e)
        {
            $result["message"] = "Server error:<br/>" . $e->getMessage();
        }
        return $result;
    }

    private function processDataFromDatabase($action, $tableName)
    {
        $result = ["result" => false, "message" => "Error reading table '$tableName'"];
        $table = new ModelDatabaseTableBase($tableName);

        switch($action)
        {
            case "get":
                $result["records"] = $table->getRecords();
                $result["result"] = true;
                $result["message"] = "";
                break;

            default:
                $result["message"] = "Invalid table action '$action'";
        }

        return $result;
    }

}
