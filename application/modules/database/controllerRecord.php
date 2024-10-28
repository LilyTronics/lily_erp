<?php

class ControllerRecord extends ControllerApplication
{

    protected function showRecord($parameters)
    {
        $record = [];
        $view = [];

        $table = ModelDatabaseTableBase::GetModelForTable($parameters["table"]);
        if ($parameters["record_id"] == "0")
        {
            $record = $table->getNewRecord();
        }
        else
        {
            $records = $table->getRecords("id = {$parameters["record_id"]}");
            if (count($records) == 1)
            {
                $record = $records[0];
            }
        }

        $pageData = [
            "menu"       => "Model{$parameters["module"]}"::getMenu(),
            "record"     => $record,
            "table"      => $parameters["table"],
            "return_uri" => $table->getReturnUri(),
            "view"       => $table->getRecordView()
        ];
        return $this->showPage("database/viewRecord", $pageData);
    }

}
