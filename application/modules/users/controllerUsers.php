<?php

class ControllerUsers extends ControllerApplication
{

    protected function showUsers($parameters)
    {
        $table = new ModelDatabaseTableUser();
        $pageData = [
            "sub_title" => "Users",
            "records"   => $table->getRecords()
        ];
        return $this->showView("Users", $pageData);
    }

    protected function showUser($parameters)
    {
        $record = [];
        $inputs = [];
        $tableName = "";
        $id = (isset($parameters["id"]) ? $parameters["id"] : null);
        if ($id != null)
        {
            $table = new ModelDatabaseTableUser();
            $record = $table->getRecordById($id);
            $inputs = $table->inputs;
            $tableName = $table->tableName;
            if ($id == 0)
            {
                $record["password"] = "";
            }
        }
        $pageData = [
            "sub_title"      => "User [{$id}]",
            "record"         => $record,
            "inputs"         => $inputs,
            "table"          => $tableName,
            "on_success_uri" => "users/user/{$id}",
            "on_failure_uri" => "users/user/{$id}",
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
