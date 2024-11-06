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

?>
<div class="w3-row-padding">
<div class="w3-col" style="width:200px"> <!-- col tables -->
<div class="w3-container w3-padding-small w3-theme">Tables</div>
<?php

if (count($tables) > 0)
{
    echo "<div class=\"w3-bar-block\">\n";
    foreach ($tables as $table)
    {
        $link = WEB_ROOT . "administrator/database-table/$table";
        echo "<a href=\"{$link}\" class=\"w3-bar-item w3-padding-small w3-button\"";
        echo " onclick=\"showModalLoader()\">{$table}</a>\n";
    }
    echo "</div>\n";
}
else
{
    echo "<p class=\"w3-padding-small\">No tables</p>\n";
}

?>
</div> <!-- col tables -->
<div class="w3-rest"> <!-- col records -->
<?php

echo "<div class=\"w3-container w3-padding-small w3-theme\">";
if ($record !== null)
{
    // show record
    echo "Record data for record with ID: {$record["id"]}</div>";
    echo $this->insertRecordForm($record, $inputs, $activeTable, $onSuccessUri, $onFailureUri, $onDeleteUri);
}
elseif ($activeTable != "")
{
    echo "Records of {$activeTable}</div>";
    echo "<div class=\"w3-container w3-padding-small\">\n";
    echo "<p><a class=\"{TOOL_BUTTON}\" href=\"" . WEB_ROOT . "administrator/database-record/{$activeTable}/0\" ";
    echo "onclick=\"showModalLoader()\">New record</a>\n";
    if (count($records) > 0)
    {
        echo "<a class=\"{TOOL_BUTTON_RED} w3-margin-left\" href=\"" . WEB_ROOT . "administrator/database-table/{$activeTable}/delete/0\" ";
        echo "onclick=\"showModalLoader()\">Delete all records</a>";
    }
    echo "</p>\n";
    echo "</div>\n";
    echo $this->insertRecordTable($records,  "administrator/database-record/{$activeTable}/");
}
else
{
    echo "&nbsp;</div>\n";
}

?>
</div> <!-- col records -->
</div> <!-- row -->
