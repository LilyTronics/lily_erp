<?php

$pageData = $this->getPageData();

$logFiles = (isset($pageData["log_files"]) ? $pageData["log_files"] : []);

echo "<div class=\"row g-1\">\n";
// Colomn for file list
echo "<div class=\"col-md-auto\">\n";
echo "<div class=\"p-2 theme-bg-light\">Log files</div>\n";
echo "<ul class=\"nav flex-column\">\n";
foreach ($logFiles as $filename)
{
    $link = WEB_ROOT . "administrator/log-file/$filename";
    echo "<li class=\"nav-item\"><a class=\"dropdown-item p-1 px-2 theme-hover\"";
    echo "href=\"{$link}\" {LNK_SHOW_LOADER}>";
    echo strtolower(preg_replace("([A-Z])", " $0", $filename));
    echo "</a></li>\n";
}
echo "</ul>\n";
echo "</div> <!-- col -->\n";
// Column for the file contents
echo "<div class=\"col\">\n";
echo "<div class=\"p-2 theme-bg-light clearfix\">Content";
if (isset($pageData["filename"]))
{
    $deleteLink = WEB_ROOT . "administrator/delete-log-file/{$pageData["filename"]}";
    echo " of " . strtolower(preg_replace("([A-Z])", " $0", $pageData["filename"]));
    echo "<a class=\"btn btn-sm float-end theme-bg-light mx-3 p-0 \" title=\"Delete log file\" ";
    echo "href=\"{$deleteLink}\" {LNK_SHOW_LOADER}>";
    echo "<i class=\"fa-solid fa-trash-can\"></i></a>\n";
}
echo "</div>\n";
if (isset($pageData["file_content"]))
{
    echo "<div class=\"{CONTAINER}\">\n";
    echo "<pre>\n";
    echo $pageData["file_content"];
    echo "</pre>\n";
    echo "</div>\n";
}
echo "</div> <!-- col -->\n";
echo "</div> <!-- row -->\n";
echo "</div> <!-- container -->\n";
