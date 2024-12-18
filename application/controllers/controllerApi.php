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
        $onDelete = (isset($postedData["on_delete"]) ? $postedData["on_delete"] : null);
        $title = (isset($postedData["title"]) ? $postedData["title"] : "");

        $log->writeMessage("Action          : " . var_export($action, true));
        $log->writeMessage("Has record      : " . (count($record) > 0 ? "yes" : "no"));
        $log->writeMessage("On success      : " . var_export($onSuccess, true));
        $log->writeMessage("On failure      : " . var_export($onFailure, true));
        $log->writeMessage("On delete       : " . var_export($onDelete, true));
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
        // TODO: do we need to pass the result to every funtion?
        switch (true)
        {
            case ($action == "get_color_theme"):
                $log->writeMessage("Get color theme");
                $color = (isset($postedData["color"]) ? $postedData["color"] : "");
                $result = ModelColorTheme::getThemeColors($color);
                break;

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
                ModelApplicationSession::destroySession();
                $result = ["result" => true, "message" => ""];
                break;

            case ($action == "bank_upload"):
                $result = ModelBank::processUpload($result);
                break;

            case ($action == "get_bank_booking_prediction"):
                $result = ModelBank::getBookingPrediction($record);
                break;

            case (str_starts_with($action, "get_")):
            case (str_starts_with($action, "list_")):
            case (str_starts_with($action, "add_")):
            case (str_starts_with($action, "update_")):
            case (str_starts_with($action, "reconsile_")):
            case (str_starts_with($action, "delete_")):
                if (str_starts_with($action, "delete_"))
                {
                    $onSuccess = $onDelete;
                }
                $result = $this->processDatabaseAction($result, $action, $record);
                if (str_starts_with($action, "delete_") and $result["result"])
                {
                    $record = null;
                }
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
        $table = ModelDatabaseTableBase::getModelForTable($parts[1]);
        if ($table === null)
        {
            $result["message"] = "Table '{$parts[1]}' does not exist";
            return $result;
        }
        // On setting table add is not allowed, execute update instead
        if ($table->tableName == "setting" and $parts[0] == "add")
        {
            $parts[0] = "update";
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

            case "list":
                $log->writeMessage("Execute list records");
                $result["records"] = $table->listRecords();
                $result["result"] = true;
                $result["message"] = "";
                break;

            case "add":
                $log->writeMessage("Execute add record");
                $result = $table->addRecord($record, $result);
                break;


            case "update":
                $log->writeMessage("Execute update record");
                $result = $table->modifyRecord($record, $result);
                break;

            case "reconsile":
                $log->writeMessage("Execute reconsile");
                $result = $table->reconsile($record);
                break;

            case "delete":
                $log->writeMessage("Execute delete record");
                $result = $table->removeRecord($record, $result);
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
            $log->writeMessage("Go to location: '{$redirect}'");
            $result["title"] = $title;
            if ($record !== null)
            {
                $result["record"] = $record;
            }
            $this->setPageData($result);
            $this->gotoLocation($redirect);
        }

        // No redirect just send the result in JSON format
        return json_encode($result, JSON_PRETTY_PRINT);
    }

}
