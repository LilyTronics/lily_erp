<?php

$pageData = $this->getPageData();

// echo $this->insertRecordTable($pageData["records"], $pageData["record_uri"]);

?>
<div class="{CONTAINER}">
<form action="{API_URI}" method="post" enctype="multipart/form-data">
<input type="hidden" name="on_success" value="accounting/bank" />
<input type="hidden" name="on_failure" value="accounting/bank" />
<input type="hidden" name="title" value="Bank import" />
<p>Upload export from bank account (MT-940 format):</p>
<p><input class="{INPUT} width-bank-upload" type="file" name="bank_file"></p>
<p><button class="{BUTTON}" type="submit" name="action" value="bank_upload" {SHOW_LOADER}>Upload</button></p>
</form>
</div>
