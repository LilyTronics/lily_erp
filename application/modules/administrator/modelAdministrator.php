<?php

class ModelAdministrator
{

    public static function getMenu()
    {
        return [
            ["Administrator", "administrator"],
            ["Log files", "administrator/log-files"],
            ["Database", "adminstrator/database"]
        ];
    }

}
