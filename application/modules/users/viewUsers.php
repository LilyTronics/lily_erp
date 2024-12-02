<div class="{CONTAINER}">
<a class="{TOOL_BUTTON}" href="{WEB_ROOT}users/user/0" {A_SHOW_LOADER}>Add user</a>
</div>
<?php

$pageData = $this->getPageData();
$records = (isset($pageData["records"]) ? $pageData["records"] : []);

echo $this->insertRecordTable($records,  "users/user/");
