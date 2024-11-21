<header class="{CONTAINER} clearfix theme-bg">
<h2 class="float-start">Lily ERP</h2>
<?php

$pageData = $this->getPageData();

if ($pageData["is_logged_in"])
{
    echo $this->getContentFromPageFile("viewUserMenu.php");
}

?>
</header>
