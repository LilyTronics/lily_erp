<div class="{CONTAINER}">
<h4>Overview</h4>
</div>
<div class="{CONTAINER}">
<?php

// Show hierarchical view of the chart of accounts
$keys = ["number", "name", "debit_credit", "debit", "credit"];
$accounts = $this->getData("accounts", []);

if (count($accounts) > 0)
{
    $nDigits = strlen($accounts[0]["number"]);
    $nCols = count($keys);
    echo "<div class=\"table-responsive\">\n";
    echo "<table class=\"table table-hover border\">\n";
    echo "<thead><tr>\n";
    foreach ($keys as $key)
    {
        $label = ModelRecord::formatFieldName($key, true);
        echo "<th";
        if ($key == "name")
        {
            echo " class=\"w-50\"";
        }
        echo " style=\"white-space:nowrap\">{$label}</th>\n";
    }
    echo "</tr></thead>\n";
    echo "<tbody>\n";
    $totalDebit = 0;
    $totalCredit = 0;
    foreach ($accounts as $record)
    {
        $accountLink = ModelHelper::createLinkTo("accounting/chart-of-accounts/expand/{$record["number"]}");
        $amountLink = ModelHelper::createLinkTo("accounting/journal/account/{$record["number"]}");
        $level = $nDigits - 1;
        $zeros = "0";
        while ($level > 0)
        {
            if (!str_ends_with($record["number"], $zeros))
            {
                break;
            }
            $zeros .= "0";
            $level--;
        }
        if ($level == 0)
        {
            echo "<tr><td colspan=\"{$nCols}\"></td></tr>\n";
        }
        echo "<tr>\n";
        foreach ($keys as $key)
        {
            $link = "";
            $title = "";
            $value = ModelRecord::formatValue($key, $record[$key]);
            if ($key == "number")
            {
                if ($level > 0)
                {
                    $value = str_repeat("&nbsp;", $level * 3) . $value;
                }
            }
            if ($key == "number" or $key == "name")
            {
                if (str_ends_with($record["number"], "0"))
                {
                    $link = $accountLink;
                    $title = "expand category";
                }
            }
            if ($key == "debit" or $key == "credit")
            {
                $link = $amountLink;
                $title = "show details";
            }
            echo "<td style=\"white-space:nowrap\">";
            if ($link != "")
            {
                echo "<a class=\"no-link-color\" href=\"{$link}\" title=\"{$title}\" {LNK_SHOW_LOADER}>{$value}</a>";
            }
            else
            {
                echo $value;
            }
            echo "</td>\n";
            $totalDebit += $record["debit"];
            $totalCredit += $record["credit"];
        }
        echo "</tr>\n";
    }
    // Add total
    echo "<tr><td colspan=\"{$nCols}\"></td></tr>\n";
    $nCols -= 2;
    $totalDebit = ModelRecord::formatValue("debit", $totalDebit);
    $totalCredit = ModelRecord::formatValue("credit", $totalCredit);
    echo "<tr><td colspan=\"{$nCols}\">Total</td><td>{$totalDebit}</td><td>{$totalCredit}</td></tr>\n";
    echo "</table>\n";
    echo "</div> <!-- responsive -->\n";
}
else
{
    echo "<p>No accounts.</p>\n";
}

?>
</div>
<div class="{CONTAINER} border-top">
<h4>Accounts</h4>
</div>
<?php echo $this->getContentFromPageFile("database/viewRecordsTable.php", APP_MODULES_PATH); ?>
