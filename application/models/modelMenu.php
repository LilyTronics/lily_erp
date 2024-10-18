<?php

class ModelMenu
{

    public static function getMenuFor($menuName) {
        $function = "get{$menuName}Menu";
        return self::$function();
    }

    public static function getAccountingMenu()
    {
        return [
            ["Accounting", "accounting"],
            ["Bank", "accounting/bank"],
            ["Reports", [
                ["VAT", "show-report/accounting-vat"],
            ]]
        ];
    }

}
