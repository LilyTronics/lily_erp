<div class="{CONTAINER}">
<h5>Open bank transactions</h5>
<div class="row">
<div class="col-lg-4">
<?php

$records = $this->getData("open_transactions", []);

if (count($records) > 0)
{
    echo "<ul class=\"list-group list-group-flush\" style=\"min-height:350px\">\n";
    foreach ($records as $record)
    {
        $amount = ModelRecord::formatValue("amount", $record["amount"]);
        if ($record["debit_credit"] == "D")
        {
            $amount = "-" . $amount;
        }
        echo "<li id=\"li-{$record["id"]}\" name=\"li-open\" class=\"list-group-item border my-1 cursor-pointer\" ";
        echo "onclick=\"showBookingForm({$record["id"]})\">\n";
        echo "<div class=\"d-flex\">\n";
        echo "<div class=\"flex-shrink-0 me-2\"><span id=\"date-{$record["id"]}\">{$record["date"]}</span></div>\n";
        echo "<div class=\"flex-fill mx-2\"><span id=\"description-{$record["id"]}\">{$record["description"]}</span></div>\n";
        echo "<div class=\"flex-shrink-0 ms-2\"><span id=\"amount-{$record["id"]}\">{$amount}</span></div>";
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
<div class="col-lg-7">
<div id="booking-form" class="border m-1 p-3" style="display:none">
<p>Reconsile:</p>
<p id="booking-details"></p>
<table id="booking-lines">
<tr><th class="w-50">Account</th><th>Debit</th><th>Credit</th><th></th></tr>
<?php

$inputs = [
    "account" => ["type" => "list", "data" => "account", "width" => "large"],
    "debit"   => ["type" => "text", "width" => "small"],
    "credit"  => ["type" => "text", "width" => "small"]
];

for ($i = 0; $i < 2; $i++)
{
    echo "<tr>\n";
    foreach (array_keys($inputs) as $key)
    {
        $inputChange = "";
        if ($key == "debit" or $key == "credit")
        {
            $inputChange = "calculateTotals()";
        }
        echo "<td>";
        echo ModelRecord::createInputFor($key, "", $inputs[$key], "line{$i}-$key", $inputChange);
        echo "</td>\n";
    }
    echo "<td></td>\n";
    echo "</tr>\n";
}

echo "<tr><td></td>\n";
echo "<td class=\"border-top\">";
echo ModelRecord::createInputFor("debit", "", ["type" => "readonly", "width" => "small"], "total-debit");
echo "</td>\n";
echo "<td  class=\"border-top\">";
echo ModelRecord::createInputFor("credit", "", ["type" => "readonly", "width" => "small"], "total-credit");
echo "</td>\n";
?>
<td><button class="{BUTTON_SMALL_LIGHT}" title="add row" type="button" onclick='addRow()'>{ICON_PLUS}</button></td>
</tr>
</table>
<input type="hidden" id="record-id" value="" />
<p><button class="{BUTTON} mx-2" type="button" onclick="confirmBooking()">Confirm</button>
<button class="{BUTTON_LIGHT}" type="button" onclick="cancelBooking()">Cancel</button></p>
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

let transfer = {};


function showBookingForm(id)
{
    transfer.clicked_id = id;
    if (document.getElementById('booking-form').checkVisibility() && hasData())
    {
        showModalConfirm('Reconsile', 'Cancel current booking?', showForm)
    }
    else
    {
        showForm();
    }
}

function cancelBooking()
{
    if (hasData())
    {
        showModalConfirm('Reconsile', 'Cancel current booking?', hideBookingForm);
    }
    else
    {
        hideBookingForm();
    }
}

function confirmBooking()
{
    let table_data = {};
    for (let elm of document.getElementById('booking-form').getElementsByTagName('input'))
    {
        if (elm.id.startsWith('line'))
        {
            let parts = elm.id.split('-');
            if (parts.length == 2)
            {
                if (!table_data[parts[0]])
                {
                    table_data[parts[0]] = {};
                }
                table_data[parts[0]][parts[1]] = elm.value;
            }
        }
    }
    let data = {}
    data.action = 'reconsile_bank_transaction';
    data.record = {}
    data.record.id = document.getElementById('record-id').value;
    data.record.lines = [];
    for (const booking in table_data)
    {
        data.record.lines.push(table_data[booking]);
    }
    apiPost(data, 'Reconsile', processResponse);
}

function processResponse(response)
{
    if (response.result)
    {
        window.location.reload();
    }
}

function showForm()
{
    clearForm();
    clearBorders();
    let elm = document.getElementById('li-' + transfer.clicked_id);
    elm.classList.add('theme-border-light');
    document.getElementById('booking-form').style.display = 'block';
    document.getElementById('record-id').value = transfer.clicked_id;
    let details = document.getElementById('date-' + transfer.clicked_id).textContent + ' - ';
    details += document.getElementById('description-' + transfer.clicked_id).textContent + ' : ';
    details += document.getElementById('amount-' + transfer.clicked_id).textContent;
    document.getElementById('booking-details').textContent = details;
    let data = {};
    data.action = "get_bank_booking_prediction";
    data.record = {};
    data.record.id = transfer.clicked_id;
    apiPost(data, "Get booking prediction", processBookingPrediction);
}

function processBookingPrediction(response)
{
    if (response.result && response.records.length > 0)
    {
        let n_lines = response.records.length;
        while (n_lines > 2)
        {
            addRow();
            n_lines--;
        }
        let amount = Math.abs(Number(document.getElementById('amount-' + transfer.clicked_id).textContent));
        for (let i = 0; i < response.records.length; i++)
        {
            let elm = document.getElementById('line' + i + '-account');
            if (elm)
            {
                elm.value = response.records[i].account_id;
            }
            elm = document.getElementById('line' + i + '-debit');
            if (elm)
            {
                if (response.records[i].debit != null)
                {
                    elm.value = formatAmount(response.records[i].debit * amount, 2);
                }
            }
            elm = document.getElementById('line' + i + '-credit');
            if (elm)
            {
                if (response.records[i].credit != null)
                {
                    elm.value = formatAmount(response.records[i].credit * amount, 2)
                }
            }
        }
        calculateTotals();
    }
}

function clearForm()
{
    let booking_table = document.getElementById('booking-lines');
    while (booking_table.rows.length > 4)
    {
        booking_table.deleteRow(3);
    }
    for (let elm of document.getElementById('booking-form').getElementsByTagName('input'))
    {
        elm.value = '';
    }
}

function hideBookingForm()
{
    clearForm();
    document.getElementById('booking-form').style.display = 'none';
}

function hasData()
{
    for (let elm of document.getElementById('booking-form').getElementsByTagName('input'))
    {
        if (elm.id.startsWith('line') && elm.value != '')
        {
            return true;
        }
    }
    return false;
}

function clearBorders()
{
    for (let elm of document.getElementsByName('li-open'))
    {
        elm.classList.remove('theme-border-light');
    }
}

function addRow()
{
    let booking_table = document.getElementById('booking-lines');
    let insert_at = booking_table.rows.length - 2;
    let cloned_row = booking_table.rows[insert_at].cloneNode(true);
    // Change IDs of the input fiels in the cloned row and empty the fields
    for (let elm of cloned_row.getElementsByTagName('input'))
    {
        let old_id = elm.id.split('-')[0]
        let new_id = 'line' + (parseInt(old_id.replace('line', '')) + 1);
        elm.id = elm.id.replace(old_id, new_id);
        elm.value = '';
    }
    // Add remove button, if not there
    if (insert_at == 2)
    {
        let btn = document.createElement('button');
        btn.type = 'button';
        btn.className = '{BUTTON_SMALL_LIGHT}';
        btn.title = 'remove row';
        btn.innerHTML = '{ICON_XMARK}';
        btn.setAttribute('onclick', 'removeRow(this)');
        let last_cell = cloned_row.cells[cloned_row.cells.length - 1];
        last_cell.appendChild(btn);
    }
    booking_table.rows[insert_at].insertAdjacentElement('afterend', cloned_row);
}

function removeRow(elm)
{
    console.log(elm);
    // Two up is the row
    let row = elm.parentElement.parentElement;
    row.parentNode.removeChild(row);
}

function calculateTotals()
{
    let totalDebit = 0;
    let totalCredit = 0;
    for (let elm of document.getElementById('booking-form').getElementsByTagName('input'))
    {
        if (elm.id.startsWith('line'))
        {
            if (elm.value != '' && !isNaN(elm.value))
            {
                if (elm.id.endsWith("-debit"))
                {
                    totalDebit += parseFloat(elm.value);
                }
                if (elm.id.endsWith("-credit"))
                {
                    totalCredit += parseFloat(elm.value);
                }
            }
        }
    }
    document.getElementById('total-debit').value = formatAmount(totalDebit);
    document.getElementById('total-credit').value = formatAmount(totalCredit);
}

</script>
