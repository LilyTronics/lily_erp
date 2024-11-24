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
        if (!self::processUploadData($content))
        {
            $result["message"] = "Error in the uploaded file.";
            return $result;

        }
        $result["result"] = true;
        $result["message"] = "";
        return $result;
    }

    public static function processUploadData($data) {
        $transactions = ModelMT940::parseData($data);
        $bank = new ModelDatabaseTableBankTransaction();
        foreach ($transactions as $transaction)
        {
            // Check if transaction already exists
            $records = $bank->getRecords("reference = '{$transaction["reference"]}'");
            if (count($records) == 0)
            {
                $transaction["state"] = "open";
                if (!$bank->insertRecord($transaction))
                {
                    return false;
                }
            }
        }
        return true;
    }

}
