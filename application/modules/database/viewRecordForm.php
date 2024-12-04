<div class="{CONTAINER}">
<?php
// From the view call:
// echo $this->insertRecordForm();


$labelStyle = "style=\"width:150px;white-space:nowrap\"";


function createInputFor($field, $value, $input)
{
    $type = (isset($input["type"]) ? $input["type"] : null);
    $data = (isset($input["data"]) ? $input["data"] : []);
    $width = (isset($input["width"]) ? $input["width"] : "default");

    $output = "";
    switch ($type)
    {
        case "text":
        case "password":
            $output = "<input type=\"{$type}\" class=\"{INPUT} max-width-{$width}\" name=\"record[{$field}]\" value=\"{$value}\" autocomplete=\"new-{$type}\" />";
            break;

        case "select":
            $output = "<select class=\"{INPUT} w-auto\" name=\"record[{$field}]\">\n";
            $output .= "<option></option>\n";
            foreach ($data as $dataValue)
            {
                $output .= "<option";
                if ($dataValue == $value)
                {
                    $output .=  " selected";
                }
                $output .=  ">{$dataValue}</option>\n";
            }
            $output .= "</select>\n";
            break;

        default:
            // Read only, no input box, but same size
            $output = "<input type=\"text\" class=\"form-control-plaintext\" name=\"record[{$field}]\" value=\"{$value}\" readonly />";
    }
    return $output;
}


if (count($record) <= 1)
{
    echo "<p>Invalid record data</p>\n";
}
else
{
    echo "<form id=\"record-form\" action=\"" . WEB_ROOT . "api\" method=\"post\" autocomplete=\"off\">\n";
    echo "<input type=\"hidden\" name=\"record[id]\" value=\"{$record["id"]}\" />\n";
    echo "<input type=\"hidden\" name=\"on_success\" value=\"{$onSuccessUri}\" />\n";
    echo "<input type=\"hidden\" name=\"on_failure\" value=\"{$onFailureUri}\" />\n";
    echo "<input type=\"hidden\" name=\"on_delete\" value=\"{$onDeleteUri}\" />\n";
    echo "<input type=\"hidden\" name=\"title\" value=\"Save record\" />\n";
    echo "<input id=\"form-action\" type=\"hidden\" name=\"action\" value=\"";
    if ($record["id"] > 0)
    {
        echo "update_{$table}";
    }
    else
    {
        echo "add_{$table}";
    }
    echo "\" />\n";

    echo "<table class=\"width-max\">\n";
    foreach ($record as $field => $value)
    {
        if ($field != "id")
        {
            $label = ModelRecord::formatFieldName($field, true);
            $value = ModelRecord::formatValue($field, $value);
            echo "<tr>\n";
            echo "<td {$labelStyle}>{$label}:</td>\n";
            echo "<td>";
            if (array_search($field, array_keys($inputs)) !== false)
            {
                echo createInputFor($field, $value, $inputs[$field]);
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
    if ($onSuccessUri != "" && $onFailureUri != "")
    {
        echo "<button class=\"{BUTTON} m-2\" type=\"submit\" {BTN_SHOW_LOADER}>Save</button>\n";
    }
    if ($onDeleteUri != "" && $onFailureUri != "" && $record["id"] > 0)
    {
        // Add with type=button, so it does not submit the form
        echo "<button class=\"{BUTTON_RED} m-2\" type=\"button\" onclick=\"showConfirm('Delete', 'Delete {$table}?', deleteCallback)\">Delete</button>\n";
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
