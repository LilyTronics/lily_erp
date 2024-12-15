<?php

class ModelDatabaseTableBankTransaction extends ModelDatabaseTableBase {

    public function __construct() {
        $this->tableName = "bank_transaction";

        $this->fields[] = $this->createField("reference",        "VARCHAR(200)", true);
        $this->fields[] = $this->createField("own_account",      "VARCHAR(200)", true);
        $this->fields[] = $this->createField("date",             "DATE",         true);
        $this->fields[] = $this->createField("debit_credit",     "VARCHAR(1)",   true);
        $this->fields[] = $this->createField("amount",           TYPE_DECIMAL,   true);
        $this->fields[] = $this->createField("transaction_type", "VARCHAR(200)", true);
        $this->fields[] = $this->createField("counter_account",  "VARCHAR(200)", true);
        $this->fields[] = $this->createField("counter_name",     "VARCHAR(200)", true);
        $this->fields[] = $this->createField("description",      "VARCHAR(200)", true);
        $this->fields[] = $this->createField("state",            "VARCHAR(200)", true);

        $this->inputs["reference"]        = $this->createInput("text");
        $this->inputs["own_account"]      = $this->createInput("text");
        $this->inputs["date"]             = $this->createInput("date");
        $this->inputs["debit_credit"]     = $this->createInput("select", data:["D", "C"]);
        $this->inputs["amount"]           = $this->createInput("text", "small");
        $this->inputs["transaction_type"] = $this->createInput("text");
        $this->inputs["counter_account"]  = $this->createInput("text");
        $this->inputs["counter_name"]     = $this->createInput("text");
        $this->inputs["description"]      = $this->createInput("text");
        $this->inputs["state"]            = $this->createInput("select", data:["open", "closed"]);

        $this->defaultOrder = "date DESC";

        parent::__construct(true);
    }

    public function reconsile($record)
    {
        $result = ["result" => false, "message" => "Unable to reconsile transaction."];
        // Check transaction record
        $id = (isset($record["id"]) ? $record["id"] : "");
        if ($id == "")
        {
            $result["message"] = "The id field is required.";
            return $result;
        }
        $transaction = $this->getRecordById($record["id"]);
        if (!isset($transaction["id"]))
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
        $lines = (isset($record["lines"]) ? $record["lines"] : []);
        if (count($lines) == 0)
        {
            $result["message"] = "The lines field is required.";
            return $result;
        }
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
                "description" => "{$transaction["description"]}",
                "linked_item" => "{$this->tableName}:{$transaction["id"]}"
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
        if (round($totalCredit, DECIMAL_PRECISION) != round($totalDebit, DECIMAL_PRECISION))
        {
            $result["message"] = "The total debit must be equal to the total credit.";
            return $result;
        }
        if (round($totalDebit, DECIMAL_PRECISION) != round($transaction["amount"], DECIMAL_PRECISION))
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
