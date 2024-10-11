<?php

class ModelSetup
{

    public static function checkConfiguration()
    {
        if (!is_file(CONFIG_FILE))
        {
            DEBUG_LOG->writeMessage("The file: " . CONFIG_FILE . "does not exist");
            return "setup/create-config";
        }
        return null;
    }

    public static function createConfiguration($data)
    {
        $fields = [
            [ "host_name",             "host name"                     ],
            [ "database",              "database name"                 ],
            [ "db_user_name",          "database user name"            ],
            [ "db_password",           "database password"             ],
            [ "db_repeat_password",    "repeat database password"      ],
            [ "admin_email",           "administrator email address"   ],
            [ "admin_name",            "administrator name"            ],
            [ "admin_password",        "administrator password"        ],
            [ "admin_repeat_password", "repeat administrator password" ]
        ];

        $result = ["result" => false, "message" => "Failed to create the configuration."];
        if (isset($data["record"]))
        {
            $data = $data["record"];
            foreach ($fields as $field)
            {
                if (!isset($data[$field[0]]) or $data[$field[0]] == "")
                {
                    $result["message"] = "The {$field[1]} is empty";
                    return $result;
                }
            }
            if ($data["db_password"] != $data["db_repeat_password"])
            {
                $result["message"] = "The repeat database password is not matching the database password";
                return $result;
            }
            if ($data["admin_password"] != $data["admin_repeat_password"])
            {
                $result["message"] = "The repeat administrator password is not matching the administrator password";
                return $result;
            }
            $result["message"] = "";

            // Data is valid, create configuration file
            $content = "[sql]\n";
            $content .= "host={$data["host_name"]}\n";
            $content .= "database={$data["database"]}\n";
            $content .= "user={$data["db_user_name"]}\n";
            $content .= "password=\"{$data["db_password"]}\"\n\n";
            $fp = fopen(CONFIG_FILE, "w");
            fwrite($fp, $content);
            fclose($fp);

            // Add administrator user
            $record = [
                "email"    => $data["admin_email"],
                "name"     => $data["admin_name"],
                "password" => hash("sha256", $data["admin_password"])
            ];
            $user = new ModelDatabaseTableUser();
            $result["result"] = $user->insertRecord($record);
            if (!$result["result"])
            {
                $result["message"] = "Could not add the administrator to the database";
            }
        }
        else
        {
            $result["message"] = "No record data received";
        }
        return $result;
    }

}
