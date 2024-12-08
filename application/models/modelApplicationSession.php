<?php

class ModelApplicationSession extends ModelSession
{

    public static function createSession($data, $result)
    {
        $result["message"] = "Could not log in to the server.";
        $fields = [
            [ "email",    "email address" ],
            [ "password", "password"      ]
        ];
        foreach ($fields as $field)
        {
            if (!isset($data[$field[0]]) or $data[$field[0]] == "")
            {
                $result["message"] = "The {$field[1]} is empty";
                return $result;
            }
        }
        $user = new ModelDatabaseTableUser();
        $records = $user->getRecords("email = '{$data["email"]}'");
        if (count($records) != 1)
        {
            $result["message"] = "The email address is not valid.";
            return $result;
        }
        // Email address is valid
        $record = $records[0];
        $filter = "email = '{$record["email"]}'";
        // Check for password
        if ($user->hash($data["password"]) != $record["password"])
        {
            $user->updateRecord(["log_in_fail" => $record["log_in_fail"] + 1], $filter);
            if ($record["log_in_fail"] >= $user->lockMaxAttempts) {
                // Too many failed attempts
                $diff = ceil(time() - $record["last_log_in"]) / 60;
                if ($diff > $user->lockTimeout)
                {
                    // Timeout is passed
                    $user->updateRecord(["log_in_fail" => 0, "last_log_in" => time()], $filter);
                }
                else {
                    $tryAgain = ceil($user->lockTimeout - $diff);
                    $result["message"] = "You cannot log in because of too many failed attempts. You can try again after $tryAgain minutes.";
                    return $result;
                }
            }
            $result["message"] = "The password is not valid.";
            return $result;
        }
        if ($record["is_active"] != 1)
        {
            $result["message"] = "Your account is not active, contact your administrator.";
            return $result;
        }
        // Log in passed, update record and create session
        $user->updateRecord(["last_log_in" => time(), "log_in_fail" => 0], $filter);
        unset($record["password"]);
        self::setData("user", $record);
        DEBUG_LOG->writeMessage("Log in OK, session created");
        DEBUG_LOG->writeMessage("User: {$record["email"]} ({$record["id"]})");
        $result["result"] = true;
        $result["message"] = "";
        return $result;
    }

    public static function checkSession()
    {
        $activeUser = self::getData("user", null);
        if ($activeUser != null)
        {
            $table = new ModelDatabaseTableUser();
            $dbUser = $table->getRecordById($activeUser["id"]);
            if (!(isset($dbUser["is_active"]) and $dbUser["is_active"] == 1))
            {
                self::destroySession();
                $activeUser = null;
            }
        }
        return $activeUser != null;
    }

}
