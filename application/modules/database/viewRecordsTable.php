<?php
// From the view call:
// echo $this->getContentFromPageFile("database/viewRecordsTable.php", APP_MODULES_PATH);

// Mandatory
$inputs = $this->getData("inputs", []);
$records = $this->getData("records", []);
$recordUri = $this->getData("record_uri", "");

// Optional, for adding new records from the table
$itemName = $this->getData("item_name", "");
$table = $this->getData("table", "");
$onSuccessUri = $this->getData("on_success_uri", "");
$onFailureUri = $this->getData("on_failure_uri", "");

// Automatically set by application
$newRecord = $this->getData("record", []);
$result = $this->getData("result", true);


$hasInputs = false;
foreach ($inputs as $input)
{
    $hasInputs = isset($input["type"]);
    if ($hasInputs) break;
}


function getStyle($field)
{
    $style = "";
    $noWrap = ["date", "reference"];
    if (array_search($field, $noWrap) !== false)
    {
        $style = "style=\"white-space:nowrap\"";
    }
    return $style;
}


$recordLink = ModelHelper::createLinkTo($recordUri);
echo "<div class=\"{CONTAINER}\">\n";
if ($itemName != "" && $hasInputs)
{
    echo "<p><button type=\"button\" class=\"{BUTTON}\" onclick=\"showNewRecord()\">New {$itemName}</button></p>\n";
}
echo "<div class=\"table-responsive\">\n";
echo "<table class=\"table table-striped table-hover border\">\n";
echo "<thead><tr>\n";
foreach (array_keys($inputs) as $key)
{
    $label = ModelRecord::formatFieldName($key);
    echo "<th style=\"white-space:nowrap\">{$label}</th>\n";
}
echo "<th style=\"width:80px\"></th>\n";
echo "</tr></thead>\n";
echo "<tbody>\n";
if ($itemName != "" && $hasInputs)
{
    // Start with new record part, will only be shown if the new record button is clicked
    $colspan = "colspan=\"" . count($inputs) + 1 . "\"";
    $link = ModelHelper::createLinkTo("api");
    echo "<form action=\"{$link}\" method=\"post\" autocomplete=\"off\">\n";
    echo "<input type=\"hidden\" name=\"action\" value=\"add_{$table}\" />\n";
    echo "<input type=\"hidden\" name=\"record[id]\" value=\"0\" />\n";
    echo "<input type=\"hidden\" name=\"on_success\" value=\"{$onSuccessUri}\" />\n";
    echo "<input type=\"hidden\" name=\"on_failure\" value=\"{$onFailureUri}\" />\n";
    echo "<input type=\"hidden\" name=\"title\" value=\"Save {$itemName}\" />\n";
    echo "<tr id=\"new-record\"";
    if ($result)
    {
        echo " style=\"display:none\"";
    }
    echo ">\n";
    foreach (array_keys($inputs) as $i => $key)
    {
        $value = (!$result && isset($newRecord[$key]) ? $newRecord[$key] : "");
        echo "<td>";
        echo ModelRecord::createInputFor($key, $value, $inputs[$key]);
        echo "</td>\n";
    }
    echo "<td><button type=\"submit\" class=\"{BUTTON_SMALL}\" title=\"save\">{ICON_CHECK}</button>\n";
    echo "<button type=\"button\" class=\"{BUTTON_SMALL} ms-1\" title=\"cancel\" onclick=\"showNewRecord('none')\">{ICON_XMARK}</button></td>\n";
    echo "</tr></form>\n";
}
// Add records if there are any
if (count($records) > 0)
{

    foreach ($records as $record)
    {
        echo "<tr>\n";
        foreach (array_keys($record) as $key)
        {
            if ($key != "id")
            {
                $value = ModelRecord::formatValue($key, $record[$key]);
                echo "<td";
                $style = getStyle($key);
                if ($style !== "")
                {
                    echo " {$style}";
                }
                echo "><a class=\"no-link-color\" href=\"{$recordLink}{$record["id"]}\" {LNK_SHOW_LOADER}>{$value}</a></td>\n";
            }
        }
        echo "<td></td>\n";
        echo "</tr>\n";
    }
}
echo "</tbody>\n";
echo "</table>\n";
echo "</div> <!-- responsive -->\n";
if (count($records) == 0)
{
    echo "<p>No records</p>\n";
}
echo "</div>\n";

?>
<script>

'use strict'

function showNewRecord(display='')
{
    document.getElementById('new-record').style.display = display;
}

</script>
