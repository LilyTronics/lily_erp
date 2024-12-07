<?php
// From the view call:
// echo $this->insertRecordTable();


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
if ($itemName != "")
{
    echo "<div class=\"{CONTAINER}\">\n";
    echo "<a class=\"{BUTTON}\" href=\"{$recordLink}0\" {LNK_SHOW_LOADER}>New {$itemName}</a>\n";
    echo "</div>\n";
}

echo "<div class=\"{CONTAINER}\">\n";
if (count($records) > 0)
{
    echo "<div class=\"table-responsive\">\n";
    echo "<table class=\"table table-striped table-hover\">\n";
    echo "<thead><tr>\n";
    foreach (array_keys($records[0]) as $key)
    {
        if ($key != "id")
        {
            $label = ModelRecord::formatFieldName($key, true);
            echo "<th style=\"white-space:nowrap\">{$label}</th>\n";
        }
    }
    echo "</tr></thead>\n";
    echo "<tbody>\n";
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
        echo "</tr>\n";
    }
    echo "</tbody>\n";
    echo "</table>\n";
    echo "</div> <!-- responsive -->\n";
}
else
{
    echo "<p>No records</p>\n";
}
echo "</div>\n";
