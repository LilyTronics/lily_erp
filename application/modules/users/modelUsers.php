<?php

class ModelUsers
{

    public static function getMenu()
    {
        return [
            ["Users", "users"]
        ];
    }

    public function getDashboard()
    {
        return [
            "order"   => 98,
            "title"   => "Users",
            "icon"    => "fa-solid fa-users",
            "link"    => "users",
            "content" => $this->getDashboardContent()
        ];
    }

    private function getDashboardContent() {
        $table = new ModelDatabaseTableUser();
        $nActivated = count($table->getRecords("is_active = 1"));
        $nDeactivated = count($table->getRecords("is_active = 0"));
        $pastMonth = time() - (60 * 60 * 24 * 30);
        $nActive = count($table->getRecords("last_log_in >= {$pastMonth}"));
        $nNotActive = count($table->getRecords("last_log_in < {$pastMonth}"));
        $messages = [
            [
                "icon"    => "{ICON_INFORMATION}",
                "message" => "{$nActivated} activated users",
                "link"    => "users"
            ],
            [
                "icon"    => "{ICON_INFORMATION}",
                "message" => "{$nDeactivated} deactivated users",
                "link"    => "users"
            ],
            [
                "icon"    => "{ICON_INFORMATION}",
                "message" => "{$nActive} active users in the last 30 days",
                "link"    => "users"
            ],
            [
                "icon"    => "{ICON_INFORMATION}",
                "message" => "{$nNotActive} not active users in the last 30 days",
                "link"    => "users"
            ]
        ];
        return $messages;
    }

}
