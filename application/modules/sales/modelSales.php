<?php

class ModelSales
{

    public function getDashboard()
    {
        return [
            "order"   => 4,
            "title"   => "Sales",
            "icon"    => "fa-solid fa-shop",
            "link"    => "sales",
            "content" => $this->getDashboardContent()
        ];
    }

    private static function getDashboardContent() {
        return [
            ["{ICON_CHECK_OK}", "23 sales orders processed in this month"],
            ["{ICON_INFO}", "2 sales orders in draft"],
            ["{ICON_EXCLAMATION}", "6 sales orders not yet confirmed"],
            ["{ICON_EXCLAMATION}", "3 sales orders passed payment period"]
        ];
    }

}
