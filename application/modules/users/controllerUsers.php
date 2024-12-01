<?php

class ControllerUsers extends ControllerApplication
{

    protected function showUsers($parameters)
    {
        $table = new ModelDatabaseTableUser();
        $pageData = [
            "records" => $table->getRecords()
        ];
        return $this->showView("Users", $pageData);
    }

    protected function showUser($parameters)
    {
        $record = [];
        $inputs = [];
        $tableName = "";
        $recordId = (isset($parameters["id"]) ? $parameters["id"] : null);
        if ($recordId != null)
        {
            $table = new ModelDatabaseTableUser();
            $record = $table->getRecordById($recordId);
            $inputs = $table->inputs;
            $tableName = $table->tableName;
        }
        $pageData = [
            "record"         => $record,
            "inputs"         => $inputs,
            "table"          => $tableName,
            "on_success_uri" => "users/user/{$recordId}",
            "on_failure_uri" => "users/user/{$recordId}",
            "on_delete_uri"  => "users"
        ];
        return $this->showView("User", $pageData);
    }

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelUsers::getMenu();
        return $this->showPage("users/view{$pageName}", $pageData);
    }

}
