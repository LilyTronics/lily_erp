<?php

class ModelRecord
{

    public static function formatFieldName($field, $ucFirst=false)
    {
        $name = str_replace("_", " ", $field);
        if ($ucFirst)
        {
            $name = ucfirst($name);
        }
        return $name;
    }

    public static function formatValue($field, $value)
    {
        if ($field == "amount")
        {
            $value = preg_replace("/(\.\d{2}[^0]*)(0*)$/", "$1", $value);
        }
        return $value;
    }

}
