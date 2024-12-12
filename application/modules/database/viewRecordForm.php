<div class="{CONTAINER}">
<?php
// From the view call:
// echo $this->getContentFromPageFile("database/viewRecordForm.php", APP_MODULES_PATH);

// Mandatory
$record = $this->getData("record", []);

// For edit and delete
$table = $this->getData("table", "");
$onFailureUri = $this->getData("on_failure_uri", "");

// For editing
$inputs = $this->getData("inputs", []);
$onSuccessUri = $this->getData("on_success_uri", "");

// For delete
$onDeleteUri = $this->getData("on_delete_uri", "");


$hasInputs = false;
foreach ($inputs as $input)
{
    $hasInputs = isset($input["type"]);
    if ($hasInputs) break;
}

$labelStyle = "style=\"width:150px;white-space:nowrap\"";


if (count($record) <= 1)
{
    echo "<p>Invalid record data</p>\n";
}
else
{
    $action = "update";
    if ($record["id"] == 0)
    {
        $action = "add";
    }
    echo "<form id=\"record-form\" action=\"" . WEB_ROOT . "api\" method=\"post\" autocomplete=\"off\">\n";
    echo "<input type=\"hidden\" name=\"record[id]\" value=\"{$record["id"]}\" />\n";
    echo "<input type=\"hidden\" name=\"on_success\" value=\"{$onSuccessUri}\" />\n";
    echo "<input type=\"hidden\" name=\"on_failure\" value=\"{$onFailureUri}\" />\n";
    echo "<input type=\"hidden\" name=\"on_delete\" value=\"{$onDeleteUri}\" />\n";
    echo "<input type=\"hidden\" name=\"title\" value=\"Save record\" />\n";
    echo "<input id=\"form-action\" type=\"hidden\" name=\"action\" value=\"{$action}_{$table}\" />\n";
    echo "<table class=\"w-100\">\n";
    foreach ($record as $field => $value)
    {
        if ($field != "id")
        {
            $label = ModelRecord::formatFieldName($field);
            $value = ModelRecord::formatValue($field, $value);
            echo "<tr>\n";
            echo "<td {$labelStyle}>{$label}:</td>\n";
            echo "<td>";
            if (array_search($field, array_keys($inputs)) !== false)
            {
                echo ModelRecord::createInputFor($field, $value, $inputs[$field]);
            }
            else
            {
                echo $value;
            }
            echo "</td>\n";
            echo "</tr>\n";
        }
    }
    echo "</table>\n";
    echo "<p class=\"form-buttons\">\n";
    if ($onSuccessUri != "" && $onFailureUri != "" && $hasInputs)
    {
        echo "<button class=\"{BUTTON} m-2\" type=\"submit\" {BTN_SHOW_LOADER}>Save</button>\n";
    }
    if ($onDeleteUri != "" && $onFailureUri != "" && $record["id"] > 0)
    {
        // Add with type=button, so it does not submit the form
        echo "<button class=\"{BUTTON_RED} m-2\" type=\"button\" onclick=\"showModalConfirm('Delete', 'Delete {$table}?', deleteCallback)\">Delete</button>\n";
    }
    echo "</p>\n";
    echo "</form>\n";
}

?>
</div>
<script>

'use strict';

function deleteCallback(evt)
{
    showLoader();
    document.getElementById('form-action').value = "delete_<?php echo $table; ?>";
    document.getElementById("record-form").submit();
}

</script>
