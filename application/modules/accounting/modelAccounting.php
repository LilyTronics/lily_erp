<?php

class ModelAccounting
{

    public static function getMenu()
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
