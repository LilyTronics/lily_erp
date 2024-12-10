<div class="{CONTAINER}">
<h5>Open bank transactions</h5>
<div class="row">
<div class="col-sm-4">
<?php

$records = $this->getData("open_transactions", []);

if (count($records) > 0)
{
    echo "<ul class=\"list-group list-group-flush\">\n";
    foreach ($records as $record)
    {
        $amount = ModelRecord::formatValue("amount", $record["amount"]);
        if ($record["debit_credit"] == "D")
        {
            $amount = "-" . $amount;
        }
        echo "<li class=\"list-group-item border my-1 cursor-pointer\" onclick=\"showBookingForm({$record["id"]}, {$amount})\">\n";
        echo "<div class=\"d-flex\">\n";
        echo "<div class=\"flex-shrink-0 me-2\">{$record["date"]}</div>\n";
        echo "<div class=\"flex-fill mx-2\">{$record["description"]}</div>\n";
        echo "<div class=\"flex-shrink-0 ms-2\">{$amount}</div>";
        echo "</div>\n";
        echo "<div class=\"small\">\n";
        echo "<table class=\"table-compact small m-1\">\n";
        echo "<tr><td>Transaction type:</td><td>{$record["transaction_type"]}</td></tr>\n";
        echo "<tr><td>Counter account:</td><td>{$record["counter_account"]} / {$record["counter_name"]}</td></tr>\n";
        echo "<tr><td>Own account:</td><td>{$record["own_account"]}</td></tr>\n";
        echo "</table>\n";
        echo "</div>\n";
        echo "</li>\n";
    }
    echo "</ul>\n";
}
else
{
    echo "<p>No open transactions</p>";
}
?>
</div> <!-- col -->
<div class="col-sm-7">
<div id="booking-form" style="display:none">
<p>Reconsile:</p>
<table>
<tr><th class="w-50">Account</th><th>Debit</th><th>Credit</th><th></th></tr>
<?php

$inputs = [
    "account" => ["type" => "list", "data" => "account", "width" => "large"],
    "debit"   => ["type" => "text", "width" => "small"],
    "credit"  => ["type" => "text", "width" => "small"]
];

for ($i = 0; $i < 3; $i++)
{
    echo "<tr>\n";
    foreach (array_keys($inputs) as $key)
    {
        echo "<td>";
        echo ModelRecord::createInputFor($key, "", $inputs[$key], "r{$i}-$key");
        echo "</td>\n";
    }
    echo "<td><button class=\"btn btn-light px-2 py-1\" title=\"delete row\">{ICON_XMARK}</button>\n";
    echo "</tr>\n";
}

?>
<tr><td></td><td><span id="total-debit"></span></td><td><span id="total-credit"></span></td>
<td><button class="btn btn-light px-2 py-1" title="add row">{ICON_PLUS}</button></td></tr>
</table>
<p><button class="{BUTTON} mx-2">Confirm</button>
<button class="{BUTTON}">Cancel</button></p>
</div>
</div> <!-- col -->
</div> <!-- row -->
</div>
<div class="{CONTAINER} border-top">
<h5>Upload bank transactions</h5>
<form action="{API_URI}" method="post" enctype="multipart/form-data">
<input type="hidden" name="on_success" value="accounting/bank" />
<input type="hidden" name="on_failure" value="accounting/bank" />
<input type="hidden" name="title" value="Bank import" />
<p>Upload export from bank account (MT-940 format):</p>
<p><input class="{INPUT} max-width-large" type="file" name="bank_file"></p>
<p><button class="{BUTTON}" type="submit" name="action" value="bank_upload" {BTN_SHOW_LOADER}>Upload</button></p>
</form>
</div>
<div class="{CONTAINER} border-top">
<h5>All bank transactions</h5>
</div>
<?php echo $this->getContentFromPageFile("database/viewRecordsTable.php", APP_MODULES_PATH); ?>
<script>

'use strict';

function showBookingForm(id, amount)
{
    document.getElementById('booking-form').style.display = 'block';
    console.log(id, amount);
}

</script>
