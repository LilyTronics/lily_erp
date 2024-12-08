<?php echo $this->getContentFromPageFile("database/viewRecordsTable.php", APP_MODULES_PATH); ?>
<div class="{CONTAINER} border-top">
<form action="{API_URI}" method="post" enctype="multipart/form-data">
<input type="hidden" name="on_success" value="accounting/bank" />
<input type="hidden" name="on_failure" value="accounting/bank" />
<input type="hidden" name="title" value="Bank import" />
<p>Upload export from bank account (MT-940 format):</p>
<p><input class="{INPUT} max-width-large" type="file" name="bank_file"></p>
<p><button class="{BUTTON}" type="submit" name="action" value="bank_upload" {BTN_SHOW_LOADER}>Upload</button></p>
</form>
</div>
