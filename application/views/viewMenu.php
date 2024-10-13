<?php

$pageData = $this->getUserData("page_data", []);

$menuClass = "w3-bar-item w3-button w3-padding-small";

if (isset($pageData["page_name"]) and isset($pageData["menu"]))
{
    echo "<div class=\"w3-container w3-padding-small w3-border-bottom\">\n";
    // Insert link to dashboard
    echo "<a class=\"$menuClass\" href=\"" . WEB_ROOT . "dashboard\" title=\"dashboard\"><i class=\"fa-solid fa-grip\"></i></a>\n";
    // Page name
    echo "<span class=\"w3-bar-item w3-padding-small\">{$pageData["page_name"]}</span>\n";
    // Add menu items
    foreach ($pageData["menu"] as $menu)
    {
        // Menu can be link or drop down
        if (is_array($menu[1]))
        {
            // Drop down
            echo "<div class=\"w3-dropdown-hover\">\n";
            echo "<button class=\"$menuClass\">{$menu[0]} <i class=\"fa-solid fa-caret-down\"></i></button>\n";
            echo "<div class=\"w3-dropdown-content w3-bar-block w3-border w3-card\">\n";
            foreach ($menu[1] as $menuItem)
            {
                echo "<a class=\"$menuClass\" href=\"{$menuItem[1]}\">{$menuItem[0]}</a>\n";
            }
            echo "</div> <!-- drop down content -->\n";
            echo "</div> <!-- drop down -->\n";
        }
        else
        {
            // Link
            echo "<a class=\"$menuClass\" href=\"{$menu[1]}\">{$menu[0]}</a>\n";
        }

    }
    echo "</div> <!-- menu bar -->\n";
}
