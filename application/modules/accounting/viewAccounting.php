<?php

$assets = $this->getData("assets", []);
$liabilities = $this->getData("liabilities", []);
$equity = $this->getData("equity", []);

$defaultStyle = "px-2 py-1";
$noBorder = "border-end-0 border-start-0";
$borderBottom = "border border-top-0 {$noBorder}";
$borderTop = "border border-2 border-bottom-0 {$noBorder}";

$defaultClass = "class=\"border-0 {$defaultStyle}\"";
$headClass = "class=\"fw-medium {$borderBottom} {$defaultStyle}\"";
$totalClass = "class=\"fw-medium {$borderTop} {$defaultStyle}\"";
$sep = "<td {$defaultClass}>&nbsp;</td>";
$emptyPart = "<td {$defaultClass}>&nbsp;</td><td {$defaultClass}>&nbsp;</td>";


function createTotal($records, &$tablePart, $cellClass)
{
    $total = 0;
    foreach ($records as $record)
    {
        $total += $record["amount"];
        $value = ModelRecord::formatValue("amount", $record["amount"]);
        $tablePart[] = "<td {$cellClass}><span class=\"mx-3\">{$record["name"]}</span></td>" .
                       "<td {$cellClass}><span class=\"mx-3\">{$value}</span></td>";
    }
    return $total;
}


// Balance sides
$debitSide = [];
$creditSide = [];

// Assets
$debitSide[] = "<td {$headClass}>Assets</td><td {$headClass}></td>";
$totalAssets = createTotal($assets, $debitSide, $defaultClass);

// Liabilities
$creditSide[] = "<td {$headClass}>Liabilities</td><td {$headClass}></td>";
$totalLiabilities = createTotal($liabilities, $creditSide, $defaultClass);
$value = ModelRecord::formatValue("amount", $totalLiabilities);
$creditSide[] = "<td {$totalClass}>Total liabilities</td><td {$totalClass}><span class=\"mx-3\">{$value}</span></td>";

// Equity
$creditSide[] = $emptyPart;
$creditSide[] = "<td {$headClass}>Equity</td><td {$headClass}></td>";
$totalEquity = createTotal($equity, $creditSide, $defaultClass);
$value = ModelRecord::formatValue("amount", $totalEquity);
$creditSide[] = "<td {$totalClass}>Total equity</td><td {$totalClass}><span class=\"mx-3\">{$value}</span></td>";

$nLines = count($debitSide);
if (count($creditSide) > $nLines)
{
    $nLines = count($creditSide);
}

echo "<table class=\"table w-auto\">\n";
for ($i = 0; $i < $nLines; $i++)
{
    echo "<tr>";
    echo (isset($debitSide[$i]) ? $debitSide[$i] : $emptyPart);
    echo $sep;
    echo (isset($creditSide[$i]) ? $creditSide[$i] : $emptyPart);
    echo "</tr>\n";

}
echo "<tr>{$emptyPart}{$sep}{$emptyPart}</tr>\n";
$value = ModelRecord::formatValue("amount", $totalAssets);
echo "<tr><td {$totalClass}>Total assets:</td><td {$totalClass}><span class=\"mx-3\">{$value}</span></td>\n";
$value = ModelRecord::formatValue("amount", $totalLiabilities + $totalEquity);
echo $sep;
echo "<td {$totalClass}>Total liabilities + equity:</td><td {$totalClass}><span class=\"mx-3\">{$value}</span></td></tr>\n";
echo "</table>\n";

?>
