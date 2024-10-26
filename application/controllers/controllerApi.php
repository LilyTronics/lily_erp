<?php

class ControllerApi extends ControllerApplication
{

    protected function sendResult($result)
    {
        $log = new ModelSystemLogger("api");
        $log->writeMessage("Result: " . var_export($result["result"], true));
        if (!$result["result"])
        {
            $log->writeMessage("Message: " . $result["message"]);
        }
        return json_encode($result, JSON_PRETTY_PRINT);
    }

    protected function processApiCall($parameters, $isConfigurationOk, $isSessionValid)
    {
        $result = ["result" => false, "message" => "Server error, try again later."];

        $log = new ModelSystemLogger("api");
        $log->writeMessage("+----------------------------------------------------------------------+");
        $log->writeMessage("+                             Start Api log                            +");
        $log->writeMessage("+----------------------------------------------------------------------+");
        $log->writeMessage("Configuration OK: " . var_export($isConfigurationOk, true));
        $log->writeMessage("Valid session   : " . var_export($isSessionValid, true));

        $postedData = ModelHelper::getPostedData(true);

        $action = "";
        if (isset($postedData["action"]))
        {
            $action = $postedData["action"];
        }
        $log->writeMessage("Action          : {$action}");

        // If the configuration is not OK and we are not trying to create one
        if (!$isConfigurationOk and $action != "create_configuration")
        {
            $result["message"] = "The configuration is invalid";
            return $this->sendResult($result);
        }

        // If the session is not OK and we are not trying to create a cfiguration, log in or log out
        if (!$isSessionValid and $action != "create_configuration" and $action != "log_in" and $action != "log_out")
        {
            $result["message"] = "Unauthorized";
            return $this->sendResult($result);
        }

        // All good, process the call
        return $this->sendResult($this->getResultFromApiCall($postedData, $result));
    }

    private function getResultFromApiCall($postedData, $result)
    {
        $log = new ModelSystemLogger("api");
        if (!isset($postedData["action"])) {
            $result["message"] = "No action defined";
            return $result;
        }
        $log->writeMessage("Process action: '{$postedData["action"]}'");

        // Create configuration
        if ($postedData["action"] == "create_configuration" and isset($postedData["record"]))
        {
            $log->writeMessage("Create configuration");
            $result = ModelSetup::createConfiguration($postedData["record"], $result);
            return $result;
        }

        // Log in
        if ($postedData["action"] == "log_in" and isset($postedData["record"]))
        {
            $log->writeMessage("Log in");
            $result = ModelApplicationSession::createSession($postedData["record"], $result);
            return $result;
        }

        // Log_out
        if ($postedData["action"] == "log_out")
        {
            $log->writeMessage("Log out");
            ModelApplicationSession::deleteSession();
            return ["result" => true, "message" => ""];
        }

        // Database actions
        $parts = explode("_", $postedData["action"], 2);
        // First part is action: get, add, update, delete
        // Rest is table name E.G.: bank_transactions

        $log->writeMessage("Database action '{$parts[0]}' from table '{$parts[1]}'");

        $table = ModelDatabaseTableBase::GetModelForTable($parts[1]);

        // Check the action
        switch ($parts[0])
        {
            case "get":
                $result["records"] = $table->getRecords();
                $result["result"] = true;
                $result["message"] = "";
                break;

            default:
                $result["message"] = "Invalid table action '{$parts[0]}'";
        }

        return $result;
    }

}
