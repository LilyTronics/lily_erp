<?php

$pageData = $this->getPageData();

$logFiles = (isset($pageData["LogFiles"]) ? $pageData["LogFiles"] : []);

if (count($logFiles) > 0)
{
    echo "<div class=\"\">\n";
    // Column for file list
    echo "<div class=\"\" style=\"width:200px\">\n";
    echo "<div class=\"\">Log files</div>\n";
    echo "<div class=\"\">\n";
    foreach ($logFiles as $filename)
    {
        $link = WEB_ROOT . "administrator/log-file/$filename";
        echo "<a href=\"{$link}\" class=\"\"";
        echo " {SHOW_LOADER}>";
        echo strtolower(preg_replace("([A-Z])", " $0", $filename));
        echo "</a>\n";
    }
    echo "</div>\n";
    echo "</div>\n";

    // Columns for the file content
    echo "<div class=\"\">\n";
    echo "<div class=\"\">Content";
    if (isset($pageData["Content"]["Filename"]))
    {
        $deleteLink = WEB_ROOT . "administrator/delete-log-file/{$pageData["Content"]["Filename"]}";
        echo " of " . strtolower(preg_replace("([A-Z])", " $0", $pageData["Content"]["Filename"]));
        echo "<a class=\"\" href=\"{$deleteLink}\" {SHOW_LOADER} title=\"Delete log file\">";
        echo "<i class=\"fa-solid fa-trash-can\"></i></a>\n";
    }
    echo "</div>\n";
    if (isset($pageData["Content"]["FileContent"]))
    {
        echo "<pre class=\"\">\n";
        echo $pageData["Content"]["FileContent"];
        echo "</pre>\n";
    }
    echo "</div>\n";

    echo "</div>\n";
}
else
{
    echo "<p>No log files found.</p>";
}

?>


