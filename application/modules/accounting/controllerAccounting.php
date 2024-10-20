<?php

class ControllerAccounting extends ControllerApplication
{

    protected function showAccounting($parameters)
    {
        $pageData = [
            "menu" => ModelAccounting::getMenu(),
        ];
        return $this->showPage("accounting/viewAccounting", $pageData);
    }

    protected function showBank($parameters)
    {
        $pageData = [
            "menu" => ModelAccounting::getMenu(),
        ];
        if (isset($parameters["upload_message"])) {
            $pageData["upload_message"] = $parameters["upload_message"];
        }
        return $this->showPage("accounting/viewBank", $pageData);
    }

    protected function bankUpload($parameters)
    {
        // Check if the file is received OK
        if (!isset($_FILES["bank_upload"])) {
            return $this->showBank(["upload_message" => "No file received"]);
        }
        $file = $_FILES["bank_upload"];
        if ($file["error"] != 0)
        {
            return $this->showBank(["upload_message" => "Upload failed, error code {$file["error"]}"]);
        }
        $content = @file_get_contents($file["tmp_name"]);
        if ($content === false)
        {
            return $this->showBank(["upload_message" => "Failed to read the file"]);
        }
        if (!ModelBank::processUploadData($content))
        {
            return $this->showBank(["upload_message" => "Error in uploaded file"]);
        }
        return $this->showBank([]);
    }

}
