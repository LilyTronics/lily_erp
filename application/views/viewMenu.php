<!-- <nav class="nav">
  <a class="nav-link active" aria-current="page" href="#">Active</a>
  <a class="nav-link" href="#">Link</a>
  <a class="nav-link" href="#">Link</a>
  <a class="nav-link disabled" aria-disabled="true">Disabled</a>
</nav> -->

<?php

$pageData = $this->getPageData();

$menuClass = "btn p-1 px-2 m-1 theme-btn-hover";
$itemClass = "dropdown-item theme-btn-hover";

if (isset($pageData["menu"]))
{
    echo "<nav class=\"nav\">\n";
    // Insert link to dashboard
    $link = WEB_ROOT . "dashboard";
    echo "<button class=\"$menuClass\" title=\"dashboard\" onclick=\"location.href='{$link}'\" {SHOW_LOADER}>";
    echo "<i class=\"fa-solid fa-grip\"></i></button>\n";
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
                echo "<li><button class=\"$itemClass\" onclick=\"location.href='{$link}'\" {SHOW_LOADER}>";
                echo "{$menuItem[0]}</button></li>\n";
            }
            echo "</ul>\n";
        }
        else
        {
            // Link
            $link = WEB_ROOT . $menu[1];
            echo "<button class=\"$menuClass\" onclick=\"location.href='{$link}'\" {SHOW_LOADER}>{$menu[0]}</button>\n";
        }

    }
    echo "</nav>\n";
}
