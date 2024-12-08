<?php

class ControllerUsers extends ControllerApplication
{

    protected function showUsers($parameters)
    {
        $table = new ModelDatabaseTableUser();
        $pageData = [
            "sub_title"      => "Users",
            "records"        => $table->getRecords(),
            "record_uri"     => "users/user/",
            "item_name"      => "user",
            "inputs"         => $table->inputs,
            "table"          => $table->tableName,
            "on_success_uri" => REQUEST_URI,
            "on_failure_uri" => REQUEST_URI
        ];
        return $this->showView("Users", $pageData);
    }

    protected function showUser($parameters)
    {
        $deleteUri = "users";
        $id = (isset($parameters["id"]) ? $parameters["id"] : 0);
        $table = new ModelDatabaseTableUser();
        $inputs = $table->inputs;
        $record = $table->getRecordById($id);
        if ($id >0 )
        {
            // Disable changing the password
            $inputs["password"] = [];
            $activeUser = ModelApplicationSession::getData("user");
            if ($id == $activeUser["id"])
            {
                // You cannot delete yourself
                $deleteUri = "";
                // You cannot deactivate yourself
                $inputs["is_active"] = [];
                // You cannot change your own access rights
                $inputs["is_admin"] = [];
                $inputs["access_levels"] = [];
            }
        }
        $pageData = [
            "sub_title"      => "User [{$id}]",
            "record"         => $record,
            "table"          => $table->tableName,
            "inputs"         => $inputs,
            "on_success_uri" => "users/user/{$id}",
            "on_failure_uri" => "users/user/{$id}",
            "on_delete_uri"  => $deleteUri
        ];
        return $this->showView("User", $pageData);
    }

    private function showView($pageName, $pageData=[])
    {
        $pageData["menu"] = ModelUsers::getMenu();
        return $this->showPage("users/view{$pageName}", $pageData);
    }

}
