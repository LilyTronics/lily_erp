<?php

echo "<table>";
for ($i = 0; $i < 32; $i++)
{
    echo "<tr>";
    $value = floatval(sprintf( "2.%06d", decbin($i)));
    echo "<td>{$value}</td>";
    $value = number_format($value, 6);
    echo "<td>{$value}</td>";
    $value = ModelRecord::formatValue("amount", $value);
    echo "<td>{$value}</td>";
    echo "</tr>";
}
echo "</table>";

?>
