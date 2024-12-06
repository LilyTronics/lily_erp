<div class="clearfix">
<?php

$pageData = $this->getPageData();

if (isset($pageData["items"]))
{
    foreach ($pageData["items"] as $itemData)
    {
        $link = WEB_ROOT . $itemData["link"];
        echo "<div class=\"card shadow-sm float-start dashboard-item m-2\">\n";
        echo "<div class=\"theme-bg p-1 rounded-top fs-5\">\n";
        echo "<a class=\"no-link-color d-block\" href=\"{$link}\" {LNK_SHOW_LOADER}>";
        echo "<i class=\"{$itemData["icon"]} mx-2\"></i>{$itemData["title"]}\n";
        echo "</a>\n";
        echo "</div> <!-- header -->\n";
        echo "<div class=\"p-2\">\n";
        // Content should be an array with items (icon, message)
        if (count($itemData["content"]) > 0)
        {
            echo "<ul class=\"fa-ul\" style=\"margin-left:1.5em\">\n";
            foreach ($itemData["content"] as $item)
            {
                $link = ModelHelper::createLinkTo($item["link"]);
                echo "<li>";
                if ($link != "")
                {
                    echo "<a href=\"{$link}\">";
                }
                echo "<span class=\"fa-li\">{$item["icon"]}</span> {$item["message"]}";
                if ($link != "")
                {
                    echo "</a>";
                }
                echo "</li>\n";
            }
            echo "</ul>\n";
        }
        echo "</div> <!-- content -->\n";
        echo "</div> <!-- card -->\n";
    }
}

?>
</div>
