<?php

class ModelBank
{

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
