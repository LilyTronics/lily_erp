<?php

$pageData = $this->getPageData();

$logFiles = (isset($pageData["LogFiles"]) ? $pageData["LogFiles"] : []);

echo "<div class=\"row g-1\">\n";
// Colomn for file list
echo "<div class=\"col-md-auto\">\n";
echo "<div class=\"p-2 theme-bg\">Log files</div>\n";
echo "<ul class=\"nav flex-column\">\n";
foreach ($logFiles as $filename)
{
    $link = WEB_ROOT . "administrator/log-file/$filename";
    echo "<li class=\"nav-item\"><button class=\"dropdown-item p-1 px-2 theme-btn-hover\"";
    echo "onclick=\"location.href='{$link}'\" {SHOW_LOADER}>";
    echo strtolower(preg_replace("([A-Z])", " $0", $filename));
    echo "</button></li>\n";
}
echo "</ul>\n";
echo "</div> <!-- col -->\n";
// Column for the file contents
echo "<div class=\"col\">\n";
echo "<div class=\"p-2 theme-bg clearfix\">Content";
if (isset($pageData["Filename"]))
{
    $deleteLink = WEB_ROOT . "administrator/delete-log-file/{$pageData["Filename"]}";
    echo " of " . strtolower(preg_replace("([A-Z])", " $0", $pageData["Filename"]));
    echo "<button class=\"btn btn-sm float-end theme-bg mx-3 p-0 \" title=\"Delete log file\" ";
    echo "onclick=\"location.href='{$deleteLink}'\" {SHOW_LOADER}>";
    echo "<i class=\"fa-solid fa-trash-can\"></i></button>\n";
}
echo "</div>\n";
if (isset($pageData["FileContent"]))
{
    echo "<pre class=\"p-3\">\n";
    echo $pageData["FileContent"];
    echo "</pre>\n";
}
else
{
    echo "<p class=\"p-2\">No file content</p>\n";
}
echo "</div> <!-- col -->\n";
echo "</div> <!-- row -->\n";
echo "</div> <!-- container -->\n";
