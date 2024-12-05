<?php

class ModelRecord
{

    public static function formatFieldName($field, $ucFirst=false)
    {
        if ($field == "debit_credit")
        {
            $name = "D/C";
        }
        else
        {
            $name = str_replace("_", " ", $field);
            if ($ucFirst)
            {
                $name = ucfirst($name);
            }
        }
        return $name;
    }

    public static function formatValue($field, $value)
    {
        $value = ($value === null ? "" : $value);
        if ($field == "amount" or $field == "debit" or $field == "credit")
        {
            $value = preg_replace("/(\.\d{2}[^0]*)(0*)$/", "$1", $value);
        }
        return htmlentities($value);
    }

}
