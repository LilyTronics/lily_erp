<p>On this page you can make changes directly in the database.</p>
<?php

$pageData = $this->getPageData();

$tables = (isset($pageData["Tables"]) ? $pageData["Tables"] : []);

if (count($tables) > 0)
{
    echo "<div class=\"w3-row-padding\">\n";
    // Column for file list
    echo "<div class=\"w3-col\" style=\"width:200px\">\n";
    echo "<div class=\"w3-container w3-padding-small w3-theme\">Log files</div>\n";
    echo "<div class=\"w3-bar-block\">\n";
    foreach ($tables as $table)
    {

        $link = WEB_ROOT . "administrator/database-table/$table";
        echo "<a href=\"{$link}\" class=\"w3-bar-item w3-padding-small w3-button\"";
        echo " onclick=\"showModalLoader()\">";
        echo strtolower(preg_replace("([A-Z])", " $0", $table));
        echo "</a>\n";
    }
    echo "</div>\n";
    echo "</div>\n";

    // Column for the table content
    $table = (isset($pageData["Content"]["table"]) ? $pageData["Content"]["table"] : "");
    echo "<div class=\"w3-rest\">\n";
    echo "<div class=\"w3-container w3-padding-small w3-theme\">Records of {$table}\n";
    echo "</div>\n";
    echo "<div class=\"w3-container w3-padding-small\">\n";
    echo "<p><a class=\"{TOOL_BUTTON}\" href=\"" . WEB_ROOT . "administrator/database-record/{$table}/0\">New record</a>\n";
    echo "</div>\n";
    echo "<div class=\"w3-container w3-padding-small\">\n";
    if (isset($pageData["Content"]["records"]))
    {
        if (count($pageData["Content"]["records"]) > 0)
        {
            echo "<div class=\"w3-responsive w3-margin-top\">\n";
            echo "<table class=\"w3-table-all w3-hoverable record-table\">\n";
            echo "<thead><tr class=\"w3-theme\">";
            foreach (array_keys($pageData["Content"]["records"][0]) as $key)
            {
                echo "<th>{$key}</th>\n";
            }
            echo "</tr></thead>\n";
            echo "<tbody>\n";
            foreach ($pageData["Content"]["records"] as $record)
            {
                $recordLink = WEB_ROOT . "administrator/database-record/{$pageData["Content"]["table"]}/{$record["id"]}";
                echo "<tr onclick=\"showModalLoader();location.href='{$recordLink}'\">";
                foreach (array_keys($record) as $key)
                {
                    echo "<td>{$record[$key]}</td>\n";
                }
                echo "</tr>\n";
            }
            echo "</tbody>\n";
            echo "</table>\n";
            echo "</div>\n";
        }
        else
        {
            echo "<p>No records</p>\n";
        }
    }
    else
    {
        echo "<p>No records</p>\n";
    }
    echo "</div>\n";
    echo "</div>\n";

    echo "</div>\n";
}
else
{
    echo "<p>No tables found.</p>";
}

?>


