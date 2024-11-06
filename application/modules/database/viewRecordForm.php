<div class="w3-container w3-section w3-padding">
<?php
// From the view call:
// echo $this->insertRecordForm($record, $inputs, $table);


function createInputFor($field, $value, $input)
{
    $type = (isset($input["type"]) ? $input["type"] : null);
    $data = (isset($input["data"]) ? $input["data"] : []);

    $output = "";
    switch ($type)
    {
        case "text":
            $output = "<input type=\"text\" class=\"{INPUT}\" name=\"record[{$field}]\" value=\"{$value}\" />";
            break;

        case "select":
            $output = "<select class=\"{SELECT} width-auto\" name=\"record[{$field}]\">\n";
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
            $output .= $value;
    }
    return $output;
}


if (count($record) <= 1)
{
    echo "<p>Invalid record data</p>\n";
}
else
{
    echo "<div class=\"w3-responsive\">\n";
    echo "<form action=\"" . WEB_ROOT . "api\" method=\"post\">\n";
    echo "<input type=\"hidden\" name=\"record[id]\" value=\"{$record["id"]}\" />\n";
    echo "<input type=\"hidden\" name=\"on_save\" value=\"{$onSuccessUri}\" />\n";
    echo "<input type=\"hidden\" name=\"on_delete\" value=\"{$onFailureUri}}\" />\n";
    echo "<input type=\"hidden\" name=\"on_delete\" value=\"{$onDeleteUri}\" />\n";

    echo "<table class=\"w3-table width-auto\">\n";
    foreach ($record as $field => $value)
    {
        if ($field != "id")
        {
            $label = ModelRecord::formatFieldName($field, true);
            echo "<tr>\n";
            echo "<td style=\"white-space:nowrap\">{$label}:</td>\n";
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
    echo "</div>\n";
    echo "<p class=\"form-buttons\">\n";
    echo "<button class=\"{BUTTON} w3-margin-left\" type=\"submit\" name=\"action\" value=\"";
    if ($record["id"] > 0)
    {
        echo "update_{$table}";
    }
    else
    {
        echo "add_{$table}";
    }
    echo "\" onclick=\"showModalLoader()\">Save</button>\n";
    if ($record["id"] > 0)
    {
        echo "<button class=\"{BUTTON_RED} w3-margin-left\" type=\"submit\" name=\"action\" value=\"delete_{$table}\" onclick=\"showModalLoader()\">Delete</button>\n";
    }
    echo "</p>\n";
    echo "</form>\n";
}

?>
</div>
