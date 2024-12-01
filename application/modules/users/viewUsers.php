<?php

$pageData = $this->getPageData();
$records = (isset($pageData["records"]) ? $pageData["records"] : []);

echo $this->insertRecordTable($records,  "users/user/");
