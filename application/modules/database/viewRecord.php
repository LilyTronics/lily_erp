<div class="w3-container w3-section w3-padding">
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

if (count($record) == 0)
{
    echo "<p>Invalid record data</p>\n";
}
else
{
    echo "<table class=\"w3-table width-auto\">\n";
    foreach ($view as $field => $view_info)
    {
        $field_label = ucfirst(str_replace("_", " ", $field));
        echo "<tr>\n";
        echo "<td style=\"white-space:nowrap\">{$field_label}:</td>\n";
        $value = ModelRecord::formatValue($field, $record[$field]);
        echo "<td>";
        if ($view_info == "")
        {
            echo $value;
        }
        else
        {
            $input = "<input class=\"{INPUT}\"";
            $data = "";
            $parts = explode("|", $view_info);
            $width = "";
            foreach ($parts as $part)
            {
                if (str_starts_with($part, "width:"))
                {
                    $width = explode(":", $part)[1];
                    break;
                }
            }
            switch ($parts[0])
            {
                case "text":
                    $input .= " type=\"text\"";
                    if (Count($parts) > 2 and $parts[1] == "datalist")
                    {
                        $input .= " list=\"list-{$field}\"";
                        $data = "<datalist id=\"list-{$field}\"></datalist>";
                    }
                    break;

                case "number":
                    $input .= " type=\"number\"";
                    if (Count($parts) > 1)
                    {
                        $range = explode(",", $parts[1]);
                        if (Count($range) == 2)
                        {
                            $input .= " min=\"{$range[0]}\" max=\"{$range[1]}\"";
                        }
                    }
                    break;

                case "select":
                    $input = "<select class=\"{SELECT}\"";
                    if ($width != "")
                    {
                        $input .= " style=\"width:{$width}px\"";
                    }
                    $input .= " >\n";
                    if (Count($parts) > 1)
                    {
                        $input .= "<option></option>\n";
                        $options = explode(",", $parts[1]);
                        foreach ($options as $option)
                        {
                            $input .= "<option value\"{$option}\"";
                            if ($value == $option)
                            {
                                $input .= " selected";
                            }
                            $input .= ">{$option}</option>\n";
                        }
                    }
                    $input .= "</select>";

                default:
                    $value = $parts[0];
            }
            if ($parts[0] != "select")
            {
                $input .= " value=\"{$value}\"";
                if ($width != "")
                {
                    $input .= " style=\"width:{$width}px\"";
                }
                $input .= " />";
            }
            echo $input;
            if ($data != "")
            {
                echo "\n{$data}";
            }
        }
        echo "</td>\n";
        echo "</tr>\n";
    }
    echo "</table>\n";
}

?>
</div>
