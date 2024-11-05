<?php

class ControllerApi extends ControllerApplication
{

    protected function processApiCall($parameters, $isConfigurationOk, $isSessionValid)
    {
        $result = ["result" => false, "message" => "Server error, try again later"];

        $log = new ModelSystemLogger("api");
        $log->writeMessage("+----------------------------------------------------------------------+");
        $log->writeMessage("+                             Start Api log                            +");
        $log->writeMessage("+----------------------------------------------------------------------+");
        $log->writeMessage("Configuration OK: " . var_export($isConfigurationOk, true));
        $log->writeMessage("Valid session   : " . var_export($isSessionValid, true));

        # Get things we need from the posted data
        $postedData = ModelHelper::getPostedData();
        $action = (isset($postedData["action"]) ? $postedData["action"] : "");
        $record = (isset($postedData["record"]) ? $postedData["record"] : []);
        // Return URIs, if only one is set, copy to the other
        $onSuccess = (isset($postedData["on_success"]) ? $postedData["on_success"] : null);
        $onFailure = (isset($postedData["on_failure"]) ? $postedData["on_failure"] : null);
        $onSuccess = ($onSuccess === null ? $onFailure : $onSuccess);
        $onFailure = ($onFailure === null ? $onSuccess : $onFailure);
        $title = (isset($postedData["title"]) ? $postedData["title"] : "");

        $log->writeMessage("Action          : {$action}");
        $log->writeMessage("Has record      : " . (count($record) > 0 ? "yes" : "no"));
        $log->writeMessage("On success      : " . ($onSuccess !== null ? $onSuccess : "null"));
        $log->writeMessage("On failure      : " . ($onFailure !== null ? $onFailure : "null"));
        $log->writeMessage("Dialog tile     : {$title}");

        // If the configuration is not OK and we are not trying to create one
        if (!$isConfigurationOk and $action != "create_configuration")
        {
            $result["message"] = "The configuration is invalid";
            return $this->processResult($result, $onSuccess, $onFailure, $record, $title);
        }

        // If the session is not OK and we are not trying to create a cfiguration, log in or log out
        if (!$isSessionValid and $action != "create_configuration" and $action != "log_in" and $action != "log_out")
        {
            $result["message"] = "Unauthorized";
            return $this->processResult($result, $onSuccess, $onFailure, $record, $title);
        }

        // Process the API action
        $result = ["result" => false, "message" => "Invalid action: '{$action}'"];
        switch (true)
        {
            case ($action == "create_configuration"):
                $log->writeMessage("Create configuration");
                $result = ModelSetup::createConfiguration($record, $result);
                break;

            case ($action == "log_in"):
                $log->writeMessage("Log in");
                $result = ModelApplicationSession::createSession($record, $result);
                break;

            case ($action == "log_out"):
                $log->writeMessage("Log out");
                $log->writeMessage("Log out");
                ModelApplicationSession::deleteSession();
                $result = ["result" => true, "message" => ""];
                break;

            case (str_starts_with($action, "get_")):
            case (str_starts_with($action, "add_")):
            case (str_starts_with($action, "update_")):
            case (str_starts_with($action, "delete_")):
                $result = $this->processDatabaseAction($result, $action, $record);
                break;
        }

        return $this->processResult($result, $onSuccess, $onFailure, $record, $title);
    }

    private function processDatabaseAction($result, $action, $record)
    {
        $log = new ModelSystemLogger("api");
        // Split up in action and table
        $parts = explode("_", $action, 2);
        $log->writeMessage("Database action '{$parts[0]}' from table '{$parts[1]}'");
        $table = ModelDatabaseTableBase::GetModelForTable($parts[1]);
        if ($table === null)
        {
            $result["message"] = "Table '{$parts[1]}' does not exist";
            return $result;
        }
        // Check the action
        switch ($parts[0])
        {
            case "get":
                $log->writeMessage("Execute get records");
                $result["records"] = $table->getRecords();
                $result["result"] = true;
                $result["message"] = "";
                break;

            case "add":
                $log->writeMessage("Execute add record");
                $result["result"] = $table->addRecord($record);
                $result["message"] = "";
                if (!$result["result"])
                {
                    $result["message"] = "Could not add record: " . $table->getError();
                }
                break;


            case "update":
                $log->writeMessage("Execute update record");
                $result["result"] = $table->modifyRecord($record);
                $result["message"] = "";
                if (!$result["result"])
                {
                    $result["message"] = "Could not update record: " . $table->getError();
                }
                break;

            case "delete":
                $log->writeMessage("Execute delete record");
                $result["result"] = $table->removeRecord($record);
                $result["message"] = "";
                if (!$result["result"])
                {
                    $result["message"] = "Could not delete record: " . $table->getError();
                }
                break;
        }
        return $result;
    }

    private function processResult($result, $onSuccess, $onFailure, $record, $title)
    {
        $redirect = null;
        $log = new ModelSystemLogger("api");
        $log->writeMessage("Result: " . var_export($result["result"], true));
        if ($result["result"])
        {
            $redirect = $onSuccess;
        }
        else
        {
            $log->writeMessage("Message: {$result["message"]}");
            $redirect = $onFailure;
        }

        if ($redirect  !== null)
        {
            $log->writeMessage("Go to location: {$redirect}");
            // Pass result to the page
            $result["record"] = $record;
            $result["title"] = $title;
            $this->setPageData($result);
            $this->gotoLocation($redirect);
        }

        // No redirect just send the result in JSON format
        return json_encode($result, JSON_PRETTY_PRINT);
    }

}
