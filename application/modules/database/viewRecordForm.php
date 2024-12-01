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
            $output = "<input type=\"text\" class=\"{INPUT} max-width-{$width}\" name=\"record[{$field}]\" value=\"{$value}\" />";
            break;

        case "select":
            $output = "<select class=\"{INPUT} width-auto\" name=\"record[{$field}]\">\n";
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
    echo "<form action=\"" . WEB_ROOT . "api\" method=\"post\">\n";
    echo "<input type=\"hidden\" name=\"record[id]\" value=\"{$record["id"]}\" />\n";
    echo "<input type=\"hidden\" name=\"on_success\" value=\"{$onSuccessUri}\" />\n";
    echo "<input type=\"hidden\" name=\"on_failure\" value=\"{$onFailureUri}\" />\n";
    echo "<input type=\"hidden\" name=\"on_delete\" value=\"{$onDeleteUri}\" />\n";
    echo "<input type=\"hidden\" name=\"title\" value=\"Save record\" />\n";


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
        echo "<button class=\"{BUTTON} m-2\" type=\"submit\" name=\"action\" value=\"";
        if ($record["id"] > 0)
        {
            echo "update_{$table}";
        }
        else
        {
            echo "add_{$table}";
        }
        echo "\" {SHOW_LOADER}>Save</button>\n";
    }
    if ($onDeleteUri != "" && $onFailureUri != "" && $record["id"] > 0)
    {
        echo "<button class=\"{BUTTON_RED} m-2\" type=\"submit\" name=\"action\" value=\"delete_{$table}\" {SHOW_LOADER}>Delete</button>\n";
    }
    echo "</p>\n";
    echo "</form>\n";
}

?>
</div>
