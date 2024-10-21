<?php

class ControllerRecord extends ControllerApplication
{

    protected function showRecord($parameters)
    {
        $record = [];
        $view = [];

        $table = ModelDatabaseTableBase::GetModelForTable($parameters["table"]);
        if ($table != null)
        {
            $records = $table->getRecords("id = {$parameters["record_id"]}");
            if (count($records) == 1)
            {
                $record = $records[0];
                $view = $table->getRecordView();
            }
        }

        $pageData = [
            "menu"   => "Model{$parameters["module"]}"::getMenu(),
            "record" => $record,
            "view"   => $view
        ];
        return $this->showPage("database/viewRecord", $pageData);
    }

}
