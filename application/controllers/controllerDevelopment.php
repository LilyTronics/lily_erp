<?php

class ControllerDevelopment extends ControllerApplication
{

    protected function showDevelopment($parameters)
    {
        return $this->showPage("viewDevelopment");
    }

    protected function processPost($parameters)
    {
        $postedData = ModelHelper::GetPostedData();

        $output = "<pre>";
        $output .= var_export($postedData, true);
        $output .= "</pre>";

        $this->setPageData(["output" => $output]);
        $this->gotoLocation("development");
    }

}
