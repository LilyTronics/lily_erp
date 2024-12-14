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

}
