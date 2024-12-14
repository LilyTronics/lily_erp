<?php

class ModelBank
{

    public static function processUpload($result) {
        if (!isset($_FILES["bank_file"])) {
            $result["message"] = "No file received.";
            return $result;
        }
        $file = $_FILES["bank_file"];
        if ($file["error"] != 0)
        {
            $result["message"] = ModelUploadErrors::errorToMessage($file["error"]);
            return $result;
        }
        $content = @file_get_contents($file["tmp_name"]);
        if ($content === false)
        {
            $result["message"] = "Failed to read the file.";
            return $result;
        }
        return self::processUploadData($content);
    }

    public static function processUploadData($data) {
        $result = ["result" => false, "message" => "Could not process the transactions."];
        $transactions = ModelMT940::parseData($data);
        if (count($transactions) == 0)
        {
            $result["message"] = "No transactions found in the file.";
            return $result;
        }
        $bank = new ModelDatabaseTableBankTransaction();
        $countImported = 0;
        $countTotal = count($transactions);
        $notImported = "";
        foreach ($transactions as $transaction)
        {
            // Check if transaction already exists
            $records = $bank->getRecords("reference = '{$transaction["reference"]}'");
            if (count($records) == 0)
            {
                $transaction["state"] = "open";
                if (!$bank->insertRecord($transaction))
                {
                    $result["message"] = "Error importing transaction with reference: {$transaction["reference"]} ";
                    $result["message"] .= $bank->getError() . ".";
                    return $result;
                }
                $countImported++;
            }
            else
            {
                $notImported .= "{$transaction["date"]} - {$transaction["description"]}\n";
            }
        }
        $result["result"] = true;
        $result["message"] = "{$countImported} of {$countTotal} transactions were imported.";
        if ($notImported != "")
        {
            $result["message"] .= " The following transactions already exist:\n" . $notImported;
        }
        return $result;
    }

    public static function getBookingPrediction($record)
    {
        $result = ["result" => true, "message" => "", "records" => []];
        $id = (isset($record["id"]) ? $record["id"] : 0);
        $bank = new ModelDatabaseTableBankTransaction();
        $record = $bank->getRecordById($id);
        // Find matching records
        $filter = "AND state = 'closed' AND debit_credit = '{$record["debit_credit"]}'";
        // Same counter_account
        $matchAccount = array_count_values(
            array_column($bank->getRecords("counter_account = '{$record["counter_account"]}' {$filter}"), "id")
        );
        // Same amount
        $matchAmount = array_count_values(
            array_column($bank->getRecords("amount = {$record["amount"]} {$filter}"), "id")
        );
        // Matching description
        $matchDescription = [];
        $phrases = explode(" ", $record["description"]);
        foreach ($phrases as $phrase)
        {
            $phrase = trim($phrase);
            $matchDescription = array_merge($matchDescription,
                array_column($bank->getRecords("description LIKE '%{$phrase}%' {$filter}"), "id")
            );
        }
        $matchDescription = array_count_values($matchDescription);
        // Total scores
        $totals = array_fill_keys(array_unique(array_merge(
            array_keys($matchAccount), array_keys($matchAmount), array_keys($matchDescription)
        )), 0);
        foreach (array_keys($totals) as $key)
        {
            // Weighted total: 0.0 ... 1.0 (1.0 = full match);
            $totals[$key] += (
                (isset($matchAccount[$key])     ? 0.5 * $matchAccount[$key]                         : 0) +
                (isset($matchDescription[$key]) ? 0.4 * ($matchDescription[$key] / count($phrases)) : 0) +
                (isset($matchAmount[$key])      ? 0.1 * $matchAmount[$key]                          : 0)
            );
        }
        arsort($totals, SORT_NUMERIC);
        // Get booking lines starting with the most matching one
        // debug($matchAccount, $matchAmount, $matchDescription, $totals);
        $journal = new ModelDatabasetableJournal();
        foreach (array_keys($totals) as $id)
        {
            $bookings = $journal->getRecords("linked_item = '{$bank->tableName}:{$id}'");
            if (count($bookings) > 0)
            {
                $transaction = $bank->getRecordById($id);
                foreach ($bookings as $booking)
                {
                    unset($booking["id"]);
                    unset($booking["date"]);
                    unset($booking["description"]);
                    unset($booking["linked_item"]);
                    if ($booking["debit"] > 0)
                    {
                        $booking["debit"] = $booking["debit"] / $transaction["amount"];
                    }
                    if ($booking["credit"] > 0)
                    {
                        $booking["credit"] = $booking["credit"] / $transaction["amount"];
                    }
                    $result["records"][] = $booking;
                }
                break;
            }
        }
        return $result;
    }

}
