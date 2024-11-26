<?php

class ModelPurchase
{

    public function getDashboard()
    {
        return [
            "order"   => 3,
            "title"   => "Purchase",
            "icon"    => "fa-solid fa-basket-shopping",
            "link"    => "purchase",
            "content" => $this->getDashboardContent()
        ];
    }

    private static function getDashboardContent() {
        return [
            ["{ICON_INFO}", "2 purchase orders in draft"],
            ["{ICON_EXCLAMATION}", "6 purchase orders not yet confirmed"]
        ];
    }

}
