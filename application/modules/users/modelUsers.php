<?php

class ModelUsers
{

    public function getDashboard()
    {
        return [
            "order"   => 8,
            "title"   => "Users",
            "icon"    => "fa-solid fa-users",
            "link"    => "users",
            "content" => $this->getDashboardContent()
        ];
    }

    private static function getDashboardContent() {
        return [
            ["{ICON_CHECK_OK}", "25 actve users in this month"],
            ["{ICON_INFO}", "3 users deactivated"],
            ["{ICON_EXCLAMATION}", "1 user is locked out"],
        ];
    }

}
