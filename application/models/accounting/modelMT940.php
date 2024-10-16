<?php
class ModelMT940
{

    public static function parseData($data)
    {
        $transactions = [];

        $i = 0;
        while ($i < strlen($data))
        {
            // Each record starts with '{4:' and ends with '-}'
            $record = self::getField($data, $i, "{4:", "-}");
            if ( $record === false)
            {
                break;
            }
            // Get reference, tag: ':20:'
            $reference = "";
            $field = self::getField($record["data"], 0, ":20:", ":");
            if ($field === false)
            {
                break;
            }
            $reference = $field["data"];
            // Get accound number, tag: ':25:'
            $account = "";
            $field = self::getField($record["data"], 0, ":25:", ":");
            if ($field === false)
            {
                break;
            }
            $account = $field["data"];
            // Get sequence number, tag: ':28C:'
            $field = self::getField($record["data"], 0, ":28C:", ":");
            if ($field === false)
            {
                break;
            }
            $seqNumber = $field["data"];
            // Get transactions, can be more than one.
            $ref = 1;
            foreach (self::getTransActions($record["data"]) as $transaction)
            {
                // Add account and reference
                $transaction["reference"] = $reference . "-$ref";
                $transaction["own_account"] = $account;
                $transactions[] = $transaction;
                $ref++;
            }
            $i = $record["end"];
        }

        return $transactions;
    }

    private static function getField($data, $offset, $startTag, $endTag)
    {
        $result = false;
        $start = strpos($data, $startTag, $offset);
        if ($start !== false)
        {
            $start += strlen($startTag);
            $end = strpos($data, $endTag, $start);
            if ($end !== false) {
                $result = [
                    "start" => $start,
                    "end"   => $end,
                    "data"  => str_replace(["\n", "\r"], "", substr($data, $start, $end - $start))
                ];
            }
        }
        return $result;
    }

    private static function getTransActions($data)
    {
        $transactions = [];

        $i = 0;
        while ($i < strlen($data))
        {
            // Get line 1
            $field = self::getField($data, $i, ":61:", ":");
            if ($field === false)
            {
                break;
            }
            $line1 = $field["data"];
            // Get line 2
            $field = self::getField($data, $field["end"], ":86:", ":");
            if ($field === false)
            {
                break;
            }
            $line2 = $field["data"];
            // Find debit_credit and amount
            preg_match("/([CD])([\d,\.]+)/i", $line1, $matches);
            if (count($matches) < 3)
            {
                break;
            }
            $transaction = [
                "date"            => DateTime::createFromFormat("ymd", substr($line1, 0, 6))->format("Y-m-d"),
                "debit_credit"    => $matches[1],
                "amount"          => self::convertAmount($matches[2]),
            ];
            $parts = explode("/", $line2);
            for ($j = 0; $j < count($parts); $j++)
            {
                if ($parts[$j] == "TRTP")
                {
                    $transaction["transaction_type"] = $parts[$j + 1];
                }
                if ($parts[$j] == "IBAN")
                {
                    $transaction["counter_account"] = $parts[$j + 1];
                }
                if ($parts[$j] == "NAME")
                {
                    $transaction["counter_name"] = $parts[$j + 1];
                }
                if ($parts[$j] == "REMI")
                {
                    $transaction["description"] = $parts[$j + 1];
                }
            }
            $transactions[] = $transaction;
            $i = $field["end"];
        }

        return $transactions;
    }

    private static function convertAmount($amount)
    {
        $posDot = strpos($amount, ".");
        $posCom = strpos($amount, ",");
        if ($posDot === false)
        {
            // Comma is decimal point
            $amount = str_replace(",", ".", $amount);
        }
        elseif ($posCom !== false)
        {
            if ($posCom < $posDot)
            {
                // Comma thousand separator, remove
                $amount = str_replace(",", "", $amount);
            }
            else
            {
                // Comma is decimal point and dot is thousand separator, remove dot and replace comma
                $amount = str_replace(".", "", $amount);
                $amount = str_replace(",", ".", $amount);
            }

        }
        return floatval($amount);
    }

}


// // Get records from the file data
// $records = [];
// $i = 0;
// while ($i < strlen($data))
// {
//     $pos = strpos($data, "{4:", $i);
//     if ($pos === false)
//     {
//         break;
//     }
//     $end = strpos($data, "-}", $pos + 1);
//     if ($end === false)
//     {
//         break;
//     }
//     $records[] = substr($data, $pos, $end - $pos + 2);
//     $i = $end;
// }

// echo "<pre>";
// var_dump(count($records));
// var_dump($records[0]);

// $transactions = [];
// foreach ($records as $record) {
//     // Reference
//     $pos = strpos($record, ":20:", 0);
//     if ($pos !== false) {
//         $end = strpos($record, ":", $pos + 4);
//         var_dump(str_replace(["\n", "\r"], "", substr($record, $pos, $end - $pos)));
//     }
//     // Account number
//     $pos = strpos($record, ":25:", 0);
//     if ($pos !== false) {
//         $end = strpos($record, ":", $pos + 4);
//         var_dump(str_replace(["\n", "\r"], "", substr($record, $pos, $end - $pos)));
//     }
//     // There can be one or more transactions in a record
//     $i = 0;
//     while ($i < strlen($record))
//     {
//         $pos = strpos($record, ":61:", $i);
//         if ($pos === false)
//         {
//             break;
//         }
//         $end = strpos($record, ":", $pos + 4);
//             var_dump(str_replace(["\n", "\r"], "", substr($record, $pos, $end - $pos)));
//         $i = $end;
//     }
