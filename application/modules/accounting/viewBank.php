<?php

$pageData = $this->getUserData("page_data", []);

?>
<div class="w3-container w3-section w3-responsive" id="record-table"></div>
<div class="w3-container w3-section w3-border-top">
<form action="<?php echo WEB_ROOT; ?>accounting/bank/upload" method="post" enctype="multipart/form-data">
<p>Upload export from bank account (MT-940 format):</p>
<p><input class="{INPUT} width-bank-upload" type="file" name="bank_upload"></p>
<p><input class="{BUTTON}" type="submit" value="Upload File"></p>
</form>
</div>
<script>

'use strict';

showTable('accounting', 'bank_transaction');

<?php

if (isset($pageData["upload_message"])) {
    echo "showModal('Upload', '{$pageData["upload_message"]}');\n";
}

?>

</script>
