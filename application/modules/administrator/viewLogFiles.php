<?php

$pageData = $this->getPageData();

$logFiles = (isset($pageData["LogFiles"]) ? $pageData["LogFiles"] : []);

if (count($logFiles) > 0)
{
    echo "<div class=\"w3-row-padding\">\n";
    // Column for file list
    echo "<div class=\"w3-col\" style=\"width:200px\">\n";
    echo "<div class=\"w3-container w3-padding-small w3-theme\">Log files</div>\n";
    echo "<div class=\"w3-bar-block\">\n";
    foreach ($logFiles as $filename)
    {
        $link = WEB_ROOT . "administrator/log-file/$filename";
        echo "<a href=\"{$link}\" class=\"w3-bar-item w3-padding-small w3-button\"";
        echo " onclick=\"showModalLoader()\">";
        echo strtolower(preg_replace("([A-Z])", " $0", $filename));
        echo "</a>\n";
    }
    echo "</div>\n";
    echo "</div>\n";

    // Columns for the file content
    echo "<div class=\"w3-rest\">\n";
    echo "<div class=\"w3-container w3-padding-small w3-theme\">Content";
    if (isset($pageData["Content"]["Filename"]))
    {
        $deleteLink = WEB_ROOT . "administrator/delete-log-file/{$pageData["Content"]["Filename"]}";
        echo " of " . strtolower(preg_replace("([A-Z])", " $0", $pageData["Content"]["Filename"]));
        echo "<a class=\"w3-right\" href=\"{$deleteLink}\" onclick=\"showModalLoader()\" title=\"Delete log file\">";
        echo "<i class=\"fa-solid fa-trash-can\"></i></a>\n";
    }
    echo "</div>\n";
    if (isset($pageData["Content"]["FileContent"]))
    {
        echo "<pre class=\"w3-small w3-padding-small\">\n";
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


