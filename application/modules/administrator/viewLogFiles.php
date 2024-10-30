<p>On this page you can view and clear log files.</p>
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
        echo " of {$pageData["Content"]["Filename"]}";
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


