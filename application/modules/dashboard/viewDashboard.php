<div class="clearfix">
<?php

$pageData = $this->getPageData();

if (isset($pageData["items"]))
{
    foreach ($pageData["items"] as $itemData)
    {
        echo "<div class=\"card shadow-sm float-start dashboard-item m-3 cursor-pointer\" onclick=\"location.href='{$itemData["uri"]}'\" {SHOW_LOADER}>\n";
        echo "<div class=\"theme-bg p-2 rounded-top\">\n";
        echo "<h5>{$itemData["title"]}</h5>\n";
        echo "</div> <!-- header -->\n";
        echo "<div class=\"p-2\">\n";
        echo $itemData["content"];
        echo "</div> <!-- content -->\n";
        echo "</div> <!-- card -->\n";
    }
}

?>
</div>
