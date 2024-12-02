<div class="clearfix">
<?php

$pageData = $this->getPageData();

if (isset($pageData["items"]))
{
    foreach ($pageData["items"] as $itemData)
    {
        $link = WEB_ROOT . $itemData["link"];
        echo "<a class=\"no-link-color\" href=\"{$link}\" {LNK_SHOW_LOADER}>";
        echo "<div class=\"card shadow-sm float-start dashboard-item m-3\">\n";
        echo "<div class=\"theme-bg p-2 rounded-top fs-5\">\n";
        echo "<i class=\"{$itemData["icon"]} mx-2\"></i>{$itemData["title"]}\n";
        echo "</div> <!-- header -->\n";
        echo "<div class=\"p-2\">\n";
        // Content should be an array with items (icon, message)
        if (count($itemData["content"]) > 0)
        {
            echo "<ul class=\"fa-ul\" style=\"margin-left:1.5em\">\n";
            foreach ($itemData["content"] as $item)
            {
                echo "<li><span class=\"fa-li\">{$item[0]}</span> {$item[1]}\n";
            }
            echo "</ul>\n";
        }
        echo "</div> <!-- content -->\n";
        echo "</div> <!-- card -->\n";
        echo "</a>\n";
    }
}

?>
</div>
