<?php

$pageData = $this->getPageData();

$tables = (isset($pageData["tables"]) ? $pageData["tables"] : []);
$activeTable = (isset($pageData["table"]) ? $pageData["table"] : "");
$records = (isset($pageData["records"]) ? $pageData["records"] : []);
$record = (isset($pageData["record"]) ? $pageData["record"] : null);
$inputs = (isset($pageData["inputs"]) ? $pageData["inputs"] : []);
$onSuccessUri = (isset($pageData["on_success_uri"]) ? $pageData["on_success_uri"] : "");
$onFailureUri = (isset($pageData["on_failure_uri"]) ? $pageData["on_failure_uri"] : "");
$onDeleteUri = (isset($pageData["on_delete_uri"]) ? $pageData["on_delete_uri"] : "");

echo "<div class=\"row g-1\">\n";
// Colomn for table list
echo "<div class=\"col-md-auto\">\n";
echo "<div class=\"p-2 theme-bg-l1\">Tables</div>\n";
echo "<ul class=\"nav flex-column\">\n";
foreach ($tables as $table)
{
    $link = WEB_ROOT . "administrator/database-table/$table";
    echo "<li class=\"nav-item\"><button class=\"dropdown-item p-1 px-2 theme-hover\"";
    echo "onclick=\"location.href='{$link}'\" {SHOW_LOADER}>{$table}</button></li>\n";
}
echo "</ul>\n";
echo "</div> <!-- col -->\n";
// Column for the records
echo "<div class=\"col\">\n";
echo "<div class=\"p-2 theme-bg-l1 clearfix\">";
if ($record !== null)
{
    // Show record
    echo "Record data for record with ID: {$record["id"]}</div>";
    echo $this->insertRecordForm($record, $inputs, $activeTable, $onSuccessUri, $onFailureUri, $onDeleteUri);
}
elseif ($activeTable != "")
{
    $link = WEB_ROOT . "administrator/database-record/{$activeTable}/0";
    echo "Records of {$activeTable}</div>";
    echo "<div class=\"{CONTAINER}\">\n";
    echo "<button class=\"{TOOL_BUTTON}\" onclick=\"location.href='{$link}'\" ";
    echo "{SHOW_LOADER}>New record</button>\n";
    if (count($records) > 0)
    {
        $link = WEB_ROOT . "administrator/database-table/{$activeTable}/delete/0";
        echo "<button class=\"{TOOL_BUTTON_RED}\" onclick=\"location.href='{$link}'\" ";
        echo "{SHOW_LOADER}>Delete all records</button>";
    }
    echo "</div>\n";
    echo $this->insertRecordTable($records,  "administrator/database-record/{$activeTable}/");
}
else
{
    echo "&nbsp;</div>\n";
}
echo "</div> <!-- col -->\n";
echo "</div> <!-- row -->\n";
echo "</div> <!-- container -->\n";

?>
