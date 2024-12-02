<?php

$pageData = $this->getPageData();

$menuClass = "btn p-1 px-2 m-1 theme-hover no-link-color";
$itemClass = "dropdown-item theme-hover no-link-color";

if (isset($pageData["menu"]))
{
    echo "<nav class=\"nav border-bottom\">\n";
    // Insert link to dashboard
    $link = WEB_ROOT . "dashboard";
    echo "<a class=\"$menuClass\" title=\"dashboard\" href=\"{$link}\" {LNK_SHOW_LOADER}>";
    echo "<i class=\"fa-solid fa-grip\"></i></a>\n";
    // Add menu items
    foreach ($pageData["menu"] as $menu)
    {
        // Menu can be link or drop down
        if (is_array($menu[1]))
        {
            // Drop down
            echo "<button class=\"{$menuClass} dropdown-toggle\" data-bs-toggle=\"dropdown\">{$menu[0]}</button>\n";
            echo "<ul class=\"dropdown-menu\">\n";
            foreach ($menu[1] as $menuItem)
            {
                $link = WEB_ROOT . $menuItem[1];
                echo "<li><a class=\"$itemClass\" href=\"{$link}\" {LNK_SHOW_LOADER}>{$menuItem[0]}</a></li>\n";
            }
            echo "</ul>\n";
        }
        else
        {
            // Link
            $link = WEB_ROOT . $menu[1];
            echo "<a class=\"$menuClass\" href=\"{$link}\" {LNK_SHOW_LOADER}>{$menu[0]}</a>\n";
        }

    }
    echo "</nav>\n";
}
