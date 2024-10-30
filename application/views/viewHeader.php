<header class="w3-theme w3-container">
<h2 class="w3-left">Lily ERP</h2>
<?php

$pageData = $this->getUserData("page_data");

if ($pageData["is_logged_in"])
{
    echo $this->getContentFromPageFile("viewUserMenu.php");
}

?>
</header>
