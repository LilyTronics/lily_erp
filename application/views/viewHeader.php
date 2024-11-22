<header class="{CONTAINER} clearfix theme-bg">
<span class="float-start fs-4">Lily ERP</span>
<?php

$pageData = $this->getPageData();

if ($pageData["is_logged_in"])
{
    echo $this->getContentFromPageFile("viewUserMenu.php");
}

?>
</header>
