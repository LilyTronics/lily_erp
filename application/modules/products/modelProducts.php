<?php

class ModelProducts
{

    public function getDashboard()
    {
        return [
            "order"   => 2,
            "title"   => "Products",
            "icon"    => "fa-solid fa-boxes-stacked",
            "link"    => "products",
            "content" => $this->getDashboardContent()
        ];
    }

    private static function getDashboardContent() {
        return [
            ["{ICON_CHECK_OK}", "142 active products"],
            ["{ICON_EXCLAMATION}", "3 products are end of life and need replacements"]
        ];
    }

}
