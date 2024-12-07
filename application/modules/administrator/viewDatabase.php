<?php

$mode = $this->getData("mode", "");
$tables = $this->getData("tables", []);
$record = $this->getData("record", null);
$activeTable = $this->getData("table", "");

echo "<div class=\"row g-1\">\n";
// Colomn for table list
echo "<div class=\"col-md-auto\">\n";
echo "<div class=\"p-2 theme-bg-light\">Tables</div>\n";
echo "<ul class=\"nav flex-column\">\n";
foreach ($tables as $table)
{
    $link = WEB_ROOT . "administrator/database-table/$table";
    echo "<li class=\"nav-item\"><a class=\"dropdown-item p-1 px-2 theme-hover\"";
    echo "href=\"{$link}\" {LNK_SHOW_LOADER}>{$table}</a></li>\n";
}
echo "</ul>\n";
echo "</div> <!-- col -->\n";
// Column for the records
echo "<div class=\"col\">\n";
echo "<div class=\"p-2 theme-bg-light clearfix\">";
if ($mode == "table")
{
    echo "Records of {$activeTable}</div>";
    echo $this->getContentFromPageFile("database/viewRecordsTable.php", APP_MODULES_PATH);
}
else if ($mode == "record")
{
    echo "Record data for record with ID: {$record["id"]}</div>";
}
else
{
    echo "&nbsp;</div>\n";
}
echo "</div> <!-- col -->\n";
echo "</div> <!-- row -->\n";
echo "</div> <!-- container -->\n";

?>
