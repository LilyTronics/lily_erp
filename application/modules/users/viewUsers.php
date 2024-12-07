<?php

$records = $this->getData("records", []);
$recordUri = $this->getData("record_uri", "");
$itemName = $this->getData("item_name", "");

echo $this->insertRecordTable($records,  $recordUri, $itemName);
