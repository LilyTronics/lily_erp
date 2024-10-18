<?php

class ViewApplication extends HtmlPageView
{

    protected function insertBody()
    {
        $output = "<body>\n";
        $output .= $this->getContentFromPageFile("viewHeader.php");
        $output .= $this->getContentFromPageFile("viewModal.php");
        $output .= "<div class=\"w3-container main-content\">\n";
        $output .= $this->getContentFromPageFile("viewMenu.php");
        if (str_contains($this->pageFile, "/"))
        {
            $output .= $this->getContentFromPageFile($this->pageFile, APP_MODULES_PATH);
        }
        else
        {
            $output .= $this->getContentFromPageFile($this->pageFile);
        }
        $output .= "</div>\n";

        $output .= $this->getContentFromPageFile("viewFooter.php");
        $output .= "</body>\n";
        return $output;
    }

}
