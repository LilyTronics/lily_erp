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
            if (!is_string($value))
            {
                $value = number_format($value, 5);
            }
            $value = preg_replace("/(\.\d{2}[^0]*)(0*)$/", "$1", $value);
        }
        return htmlentities($value);
    }

    public static function createInputFor($field, $value, $input)
    {
        $type = (isset($input["type"]) ? $input["type"] : null);
        $data = (isset($input["data"]) ? $input["data"] : []);
        $width = (isset($input["width"]) ? $input["width"] : "default");

        $output = "";
        switch ($type)
        {
            case "text":
            case "password":
                $output = "<input type=\"{$type}\" class=\"{INPUT} max-width-{$width}\" name=\"record[{$field}]\" value=\"{$value}\" autocomplete=\"new-{$type}\" />";
                break;

            case "select":
                $output = "<select class=\"{INPUT} w-auto\" name=\"record[{$field}]\">\n";
                $output .= "<option></option>\n";
                foreach ($data as $dataValue)
                {
                    $output .= "<option";
                    if ($dataValue == $value)
                    {
                        $output .=  " selected";
                    }
                    $output .=  ">{$dataValue}</option>\n";
                }
                $output .= "</select>\n";
                break;

            case "date":
                $output = "<input type=\"{$type}\" class=\"{INPUT}\" name=\"record[{$field}]\" value=\"{$value}\" />";
                break;

            default:
                // Read only, no input box, but same size
                $output = "<input type=\"text\" class=\"form-control-plaintext\" name=\"record[{$field}]\" value=\"{$value}\" readonly />";
        }
        return $output;
    }

}
