<?php

class ModelInventory
{

    public function getDashboard()
    {
        return [
            "order"   => 5,
            "title"   => "Inventory",
            "icon"    => "fa-solid fa-warehouse",
            "link"    => "inventory",
            "content" => $this->getDashboardContent()
        ];
    }

    private static function getDashboardContent() {
        return [
            ["{ICON_INFO}", "5 inventory items are entering the warehouse soon"],
            ["{ICON_EXCLAMATION}", "6 shipping orders need to be processed today"]
        ];
    }

}
