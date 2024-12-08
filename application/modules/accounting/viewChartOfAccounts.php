<div class="{CONTAINER}">
<a class="{BUTTON}" href="{WEB_ROOT}accounting/chart-of-accounts/account/0" {LNK_SHOW_LOADER}>New account</a>
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
    echo "<table class=\"table-bordered\">\n";
    echo "<thead><tr>\n";
    foreach ($keys as $key)
    {
        $label = ModelRecord::formatFieldName($key, true);
        echo "<th class=\"theme-bg-light";
        if ($key == "name")
        {
            echo " w-50";
        }
        echo "\" style=\"white-space:nowrap\">{$label}</th>\n";
    }
    echo "</tr></thead>\n";
    echo "<tbody>\n";
    $totalDebit = 0;
    $totalCredit = 0;
    foreach ($accounts as $record)
    {
        $numberLink = ModelHelper::createLinkTo("accounting/chart-of-accounts/expand/{$record["number"]}");
        $nameLink = ModelHelper::createLinkTo("accounting/chart-of-accounts/account/{$record["id"]}");
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
            $stripe = 0;
        }
        echo "<tr";
        if ($stripe % 2 == 0)
        {
            echo " class=\"theme-stripe\"";
        }
        echo ">\n";
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
                $link = $numberLink;
                $title = "expand category";
            }
            if ($key == "name")
            {
                $link = $nameLink;
                $title = "edit account";
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
        $stripe++;
    }
    // Add total
    echo "<tr><td colspan=\"{$nCols}\"></td></tr>\n";
    $nCols -= 2;
    $totalDebit = ModelRecord::formatValue("debit", $totalDebit);
    $totalCredit = ModelRecord::formatValue("credit", $totalCredit);
    echo "<tr><td colspan=\"{$nCols}\">Total</td><td>{$totalDebit}</td><td>{$totalCredit}</td></tr>\n";
    echo "</table>\n";
}
else
{
    echo "<p>No accounts.</p>\n";
}

?>
</div>
