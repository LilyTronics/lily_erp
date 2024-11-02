<div class="w3-container w3-padding-small"> <!-- records table -->
<?php

function formatValue($field, $value)
{
    if ($field == "amount")
    {
        $value = preg_replace("/(\.\d{2}[^0]*)(0*)$/", "$1", $value);
    }
    return $value;
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


if (count($records) > 0)
{
    echo "<div class=\"w3-responsive\"> <!-- responsive -->\n";
    echo "<table class=\"w3-table-all w3-hoverable record-table\">\n";
    echo "<thead><tr class=\"w3-theme\">";
    foreach (array_keys($records[0]) as $key)
    {
        if ($key != "id")
        {
            $label = ucfirst(str_replace("_", " ", $key));
            echo "<th style=\"white-space:nowrap\">{$label}</th>\n";
        }
    }
    echo "</tr></thead>\n";
    echo "<tbody>\n";
    foreach ($records as $record)
    {
        $recordLink = WEB_ROOT . $recordUri . $record["id"];
        echo "<tr onclick=\"showModalLoader();location.href='{$recordLink}'\">";
        foreach (array_keys($record) as $key)
        {
            if ($key != "id")
            {
                $value = formatValue($key, $record[$key]);
                echo "<td";
                $style = getStyle($key);
                if ($style !== "")
                {
                    echo " {$style}";
                }
                echo ">{$value}</td>\n";
            }
        }
        echo "</tr>\n";
    }
    echo "</tbody>\n";
    echo "</table>\n";
    echo "</div> <!-- responsive -->\n";
}
else
{
    echo "<p>No records</p>";
}

?>
</div> <!-- records table -->
