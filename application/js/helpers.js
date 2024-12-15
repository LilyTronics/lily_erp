/* Helper functions */

'use strict';


function escapeHtml(input)
{
    return input
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


function formatAmount(amount, decimals=6)
{
    amount = amount.toFixed(decimals);
    // Must be same regular expression as in ModelRecords.php
    return amount.replace(/(\.\d{1}\d+?(?=0))(0*)$/, '$1');
}
