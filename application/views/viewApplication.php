<?php

class ViewApplication extends HtmlPageView
{

    public function getData($key, $default)
    {
        return (isset($this->pageData[$key]) ? $this->pageData[$key] : $default);
    }

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
        $result = isset($pageData["result"]) ? $pageData["result"] : null;
        $message = isset($pageData["message"]) ? $pageData["message"] : "";
        $title = isset($pageData["title"]) ? $pageData["title"] : "Server message";
        if ($result === false or ($result === true && $message != ""))
        {
            $message = htmlspecialchars($message, ENT_QUOTES);
            $message = str_replace("\n", "<br />", $message);
            $output = "<script>showModalMessage('$title', '$message');</script>\n";
        }
        return $output;
    }

}
