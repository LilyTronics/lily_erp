<?php

class ModelRelations
{

    public function getDashboard()
    {
        return [
            "order"   => 1,
            "title"   => "Relations",
            "icon"    => "fa-solid fa-address-card",
            "link"    => "relations",
            "content" => $this->getDashboardContent()
        ];
    }

    private static function getDashboardContent() {
        return [
            ["{ICON_CHECK_OK}", "16 customers placed an order this month"],
            ["{ICON_EXCLAMATION}", "2 relations are missing contact informaton"],
        ];
    }

}
