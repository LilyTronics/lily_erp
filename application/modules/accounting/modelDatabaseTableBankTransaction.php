<?php

class ModelDatabaseTableBankTransaction extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "bank_transaction";

        $this->fields[] = ["name" => "reference",        "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "own_account",      "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "date",             "type" => "DATE",             "required" => true];
        $this->fields[] = ["name" => "debit_credit",     "type" => "VARCHAR(1)",       "required" => true];
        $this->fields[] = ["name" => "amount",           "type" => self::TYPE_DECIMAL, "required" => true];
        $this->fields[] = ["name" => "transaction_type", "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "counter_account",  "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "counter_name",     "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "description",      "type" => "VARCHAR(200)",     "required" => true];
        $this->fields[] = ["name" => "state",            "type" => "VARCHAR(200)",     "required" => true];

        foreach ($this->fields as $field)
        {
            $this->inputs[$field["name"]] = [];
        }

        parent::__construct(true);
    }

    public function reconsile($record)
    {
        $result = ["result" => false, "message" => "Unable to reconsile transaction."];
        // Check transaction record
        $result["result"] = isset($record["id"]);
        if (!$result["result"])
        {
            $result["message"] = "The id field is required.";
            return $result;
        }
        $transaction = $this->getRecordById($record["id"]);
        $result["result"] = isset($transaction["id"]);
        if (!$result["result"])
        {
            $result["message"] = "The bank transaction is not found.";
            return $result;
        }
        if (!$transaction["state"] == "open")
        {
            $result["message"] = "Only open bank transactions can be reconsiled.";
            return $result;
        }
        // Check booking lines
        $result["result"] = isset($record["lines"]);
        if (!$result["result"])
        {
            $result["message"] = "The lines field is required.";
            return $result;
        }
        $result["result"] = false;
        $journalEntries = [];
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($record["lines"] as $line)
        {
            $account = (isset($line["account"]) ? $line["account"] : "");
            $debit = (isset($line["debit"]) ? $line["debit"] : "");
            $credit = (isset($line["credit"]) ? $line["credit"] : "");
            $debit = ($debit != "" ? $debit : 0);
            $credit = ($credit != "" ? $credit : 0);

            if ($line["account"] == "")
            {
                $result["message"] = "The account field is required.";
                return $result;
            }
            $accountTable = new ModelDatabaseTableAccount();
            $filter = $this->convertIdToFilter($account, $accountTable);
            $accountRecords = $accountTable->getRecords($filter);
            if (count($accountRecords) != 1)
            {
                $result["message"] = "The account does not exist.";
                return $result;
            }
            // Record found replace with real ID
            $account = $accountRecords[0]["id"];
            // Either debit or credit must be set
            if ($debit == 0 && $credit == 0)
            {
                $result["message"] = "A debit or credit field is required.";
                return $result;
            }
            if (!is_numeric($debit))
            {
                $result["message"] = "The debit amount must be numeric.";
                return $result;
            }
            if (!is_numeric($credit))
            {
                $result["message"] = "The credit amount must be numeric.";
                return $result;
            }
            $debit = floatval($debit);
            $credit = floatval($credit);
            if ($credit != 0 && $debit != 0)
            {
                $result["message"] = "Cannot enter a debit and credit amount in one line.";
                return $result;
            }
            $totalDebit += $debit;
            $totalCredit += $credit;
            $journalEntry = [
                "id" => 0,
                "date" => $transaction["date"],
                "account_id" => $account,
                "description" => "bank:{$transaction["reference"]}"
            ];
            if ($debit != 0)
            {
                $journalEntry["debit"] = $debit;
            }
            if ($credit != 0)
            {
                $journalEntry["credit"] = $credit;
            }
            $journalEntries[] = $journalEntry;
        }
        if ($totalCredit != $totalDebit)
        {
            $result["message"] = "The total debit must be equal to the total credit.";
            return $result;
        }
        if ($totalDebit != $transaction["amount"])
        {
            $result["message"] = "The total amount of the transaction must be booked.";
            return $result;
        }
        $journal = new ModelDatabaseTableJournal();
        $records = $journal->getRecords("description LIKE '%{$transaction["reference"]}%'");
        if (count($records) > 0)
        {
            $result["message"] = "Journal entries for this transaction already exist.";
            return $result;
        }
        foreach ($journalEntries as $journalEntry)
        {
            $result = $journal->addRecord($journalEntry, $result);
            if (!$result["result"])
            {
                return $result;
            }
        }
        $result["result"] = $this->updateRecord(["state" => "closed"], "id = {$transaction["id"]}");
        if (!$result["result"])
        {
            $result["message"] = "Could not close transaction: " . $this->getError() . ".";
            return $result;
        }
        $result["result"] = true;
        $result["message"] = "";
        return $result;
    }
}
