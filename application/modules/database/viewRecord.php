<?php

$pageData = $this->getUserData("page_data", []);
$record = [];
$view = [];

if (isset($pageData["record"]))
{
    $record = $pageData["record"];
}
if (isset($pageData["view"]))
{
    $view = $pageData["view"];
}

if (count($record) == 0 or count($view) == 0)
{
    echo "<p>Invalid record data</p>\n";
}
else
{
    echo "<table class=\"w3-table width-auto\">\n";
    foreach ($view as $field => $view_info)
    {
        $field_label = ucfirst(str_replace("_", " ", $field));
        echo "<tr>";
        echo "<td>{$field_label}:</td>";
        echo "<td>" . ModelRecord::formatValue($field, $record[$field]) . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
}

?>
