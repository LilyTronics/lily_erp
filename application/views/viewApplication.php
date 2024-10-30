<?php

class ViewApplication extends HtmlPageView
{

    protected function insertBody()
    {
        $pageData = $this->getUserData("page_data");
        $output = "<body>\n";
        $output .= $this->getContentFromPageFile("viewHeader.php");
        $output .= $this->getContentFromPageFile("viewModal.php");
        $output .= "<div class=\"w3-container\">\n";
        $output .= $this->getContentFromPageFile("viewMenu.php");
        $output .= "</div>\n";
        $output .= "<div class=\"w3-container w3-padding main-content\">\n";
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
            $message = str_replace("'", "\\'", $message);
            $output = "<script>showModal('$title', '$message');</script>\n";
        }
        return $output;
    }

}
