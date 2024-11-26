<?php

class ModelManufacturing
{

    public function getDashboard()
    {
        return [
            "order"   => 6,
            "title"   => "Manufacturing",
            "icon"    => "fa-solid fa-industry",
            "link"    => "manufacturing",
            "content" => $this->getDashboardContent()
        ];
    }

    private static function getDashboardContent() {
        return [
            ["{ICON_CHECK_OK}", "16 manufacturing orders processed this month"],
            ["{ICON_INFO}", "5 manufacturing orders in progress"],
            ["{ICON_EXCLAMATION}", "1 manufacturing order is delayed"],
        ];
    }

}
