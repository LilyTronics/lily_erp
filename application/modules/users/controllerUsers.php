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
        $deleteUri = "users";
        $id = (isset($parameters["id"]) ? $parameters["id"] : null);
        if ($id != null)
        {
            $table = new ModelDatabaseTableUser();
            $record = $table->getRecordById($id);
            $inputs = $table->inputs;
            $tableName = $table->tableName;
            if ($id > 0)
            {
                $inputs["password"] = [];
            }
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
            "inputs"         => $inputs,
            "table"          => $tableName,
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
