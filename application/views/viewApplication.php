<?php

class ViewApplication extends HtmlPageView
{

    protected function insertBody()
    {
        $output = "<body>\n\n";
        $output .= $this->getContentFromPageFile($this->pageFile);
        $output .= "</body>\n";
        return $output;
    }

}
