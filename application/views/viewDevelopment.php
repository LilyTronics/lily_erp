<div class="container-fluid">
<form action="<?php echo WEB_ROOT; ?>development/post" method="post">
<input type="hidden" name="action" value="development" />
<p><input class="{INPUT}" type="text" name="record[name]" /></p>
<p><button class="{BUTTON}" {SHOW_LOADER}>Submit</button></p>
</form>

<?php

$pageData = $this->getPageData();

if (isset($pageData["output"]))
{
    echo "<div class=\"container-fluid\">\n";
    echo $pageData["output"];
    echo "</div>\n";
}
