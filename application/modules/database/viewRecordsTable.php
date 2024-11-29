<div class="{CONTAINER}"> <!-- records table -->
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


if (count($records) > 0)
{
    echo "<div class=\"table-responsive\">\n";
    echo "<table class=\"table-bordered theme-table-striped theme-table-hover\">\n";
    echo "<thead><tr>\n";
    foreach (array_keys($records[0]) as $key)
    {
        if ($key != "id")
        {
            $label = ModelRecord::formatFieldName($key, true);
            echo "<th class=\"theme-bg-light\" style=\"white-space:nowrap\">{$label}</th>\n";
        }
    }
    echo "</tr></thead>\n";
    echo "<tbody>\n";
    foreach ($records as $record)
    {
        $recordLink = WEB_ROOT . $recordUri . $record["id"];
        echo "<tr class=\"cursor-pointer\" onclick=\"location.href='{$recordLink}'\" {SHOW_LOADER}>";
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
    echo "<p>No records</p>\n";
}

?>
</div> <!-- records table -->
