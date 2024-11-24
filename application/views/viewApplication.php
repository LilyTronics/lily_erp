<?php

class ViewApplication extends HtmlPageView
{

    protected function insertBody()
    {
        $pageData = $this->getPageData();

        $output = "<body>\n";
        $output .= $this->getContentFromPageFile("viewHeader.php");
        $output .= $this->getContentFromPageFile("viewModal.php");
        $output .= $this->getContentFromPageFile("viewMenu.php");
        $output .= "<div class=\"{CONTAINER} main-content\">\n";
        if (str_contains($this->pageFile, "/"))
        {
            $output .= $this->getContentFromPageFile($this->pageFile, APP_MODULES_PATH);
        }
        else
        {
            $output .= $this->getContentFromPageFile($this->pageFile);
        }
        $output .= "</div>\n";
        $output .= $this->insertShowModal($pageData);
        $output .= $this->getContentFromPageFile("viewFooter.php");
        $output .= "</body>\n";
        return $output;
    }

    private function insertShowModal($pageData) {
        $output = "";
        $result = isset($pageData["result"]) ? $pageData["result"] : true;
        $message = isset($pageData["message"]) ? $pageData["message"] : "Server error, try again later";
        $title = isset($pageData["title"]) ? $pageData["title"] : "Server message";
        if (!$result)
        {
            $message = htmlspecialchars($message, ENT_QUOTES);
            $output = "<script>showMessage('$title', '$message');</script>\n";
        }
        return $output;
    }

    public function insertRecordTable($records, $recordUri)
    {
        // Key must be same as varable name (without $)
        $variables = [
            "records"   => $records,
            "recordUri" => $recordUri
        ];
        return $this->getContentFromPageFile("database/viewRecordsTable.php", APP_MODULES_PATH, $variables);
    }

    public function insertRecordForm($record, $inputs, $table, $onSuccessUri, $onFailureUri, $onDeleteUri)
    {
        // Key must be same as varable name (without $)
        $variables = [
            "record"       => $record,
            "inputs"       => $inputs,
            "table"        => $table,
            "onSuccessUri" => $onSuccessUri,
            "onFailureUri" => $onFailureUri,
            "onDeleteUri"  => $onDeleteUri
        ];
        return $this->getContentFromPageFile("database/viewRecordForm.php", APP_MODULES_PATH, $variables);
    }

}
