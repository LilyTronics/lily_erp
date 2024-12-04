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
        return [];
    }

}
