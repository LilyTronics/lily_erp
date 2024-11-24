<?php

$pageData = $this->getPageData();
$record = (isset($pageData["record"]) ? $pageData["record"] : []);
$inputs = (isset($pageData["inputs"]) ? $pageData["inputs"] : []);
$table = (isset($pageData["table"]) ? $pageData["table"] : "");
$onSuccessUri = (isset($pageData["on_success_uri"]) ? $pageData["on_success_uri"] : "");
$onFailureUri = (isset($pageData["on_failure_uri"]) ? $pageData["on_failure_uri"] : "");
$onDeleteUri = (isset($pageData["on_delete_uri"]) ? $pageData["on_delete_uri"] : "");

echo $this->insertRecordForm($record, $inputs, $table, $onSuccessUri, $onFailureUri, $onDeleteUri);

?>
