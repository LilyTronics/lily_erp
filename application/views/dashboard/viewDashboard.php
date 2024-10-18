<div class="w3-row-padding w3-margin-top w3-margin-bottom">
<?php

$pageData = $this->getUserData("page_data", ["items" => []]);

foreach ($pageData["items"] as $itemData)
{
    echo "<div class=\"w3-col w3-margin-top dashboard-item\">\n";
    echo "<div class=\"w3-card cursor-pointer\" onclick=\"location.href='{$itemData["uri"]}'\">\n";
    echo "<div class=\"w3-container w3-theme\">\n";
    echo "<h5>{$itemData["title"]}</h5>\n";
    echo "</div> <!-- header -->\n";
    echo "<div class=\"w3-container w3-padding dashboard-item-content\">\n";
    echo $itemData["content"];
    echo "</div> <!-- content -->\n";
    echo "</div> <!-- card -->\n";
    echo "</div> <!-- col -->\n";
}

?>
</div> <!--row -->
