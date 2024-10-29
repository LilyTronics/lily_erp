<div class="w3-container w3-section">
<form action="<?php echo WEB_ROOT; ?>development/post" method="post">
<input type="hidden" name="action" value="development" />
<p><input class="{INPUT}" type="text" name="record[name]" /></p>
<p><button class="{BUTTON}" onclick="showModalLoader()">Submit</button></p>
</form>

<?php

$pageData = $this->getUserData("page_data");

if ($pageData["view_output"] != null)
{
    echo "<div class=\"w3-container w3-section\">\n";
    echo $pageData["view_output"];
    echo "</div>\n";
}
