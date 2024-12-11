<?php

class ModelRecord
{

    public static function formatFieldName($field)
    {
        if ($field == "debit_credit")
        {
            $field = "D/C";
        }
        else
        {
            if (str_ends_with($field, "_id"))
            {
                $field = str_replace("_id", "", $field);
            }
            $field = ucfirst(str_replace("_", " ", $field));
        }
        return $field;
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

    public static function createInputFor($field, $value, $input, $id="", $inputChange="")
    {
        $type = (isset($input["type"]) ? $input["type"] : null);
        $data = (isset($input["data"]) ? $input["data"] : []);
        $width = (isset($input["width"]) ? $input["width"] : "default");
        $isDataList = $type == "list" and $data != [];

        if ($id == "")
        {
            $id = "name=\"record[{$field}]\"";
        }
        else
        {
            $id = "id=\"{$id}\"";
        }
        if ($inputChange != "")
        {
            $inputChange = "oninput=\"{$inputChange}\" ";
        }
        $output = "";
        switch ($type)
        {
            case "text":
            case "password":
            case "list":
                $output = "<input type=\"{$type}\" class=\"{INPUT} max-width-{$width}\" {$id} ";
                $output .= "value=\"{$value}\" autocomplete=\"new-{$type}\" ";
                if ($isDataList)
                {
                    $output .= "list=\"list_{$data}\" onfocus=\"populateDataList('$data')\" ";
                }
                $output .= "{$inputChange}/>";
                if ($isDataList)
                {
                    $output .= "<datalist id=\"list_{$data}\"></datalist>";
                }
                break;

            case "select":
                $output = "<select class=\"{INPUT} w-auto\" {$id} {$inputChange}>\n";
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
                $output = "<input type=\"{$type}\" class=\"{INPUT} w-auto\" {$id} ";
                $output .= "value=\"{$value}\" {$inputChange}/>";
                break;

            case "readonly":
                $output = "<input type=\"text\" class=\"{INPUT} max-width-{$width}\" {$id} ";
                $output .= "value=\"{$value}\" autocomplete=\"new-{$type}\" readonly />";
                break;

            default:
                // Read only, no input box, but same size
                $output = "<input type=\"text\" class=\"form-control-plaintext\" {$id} ";
                $output .= "value=\"{$value}\" readonly />";
        }
        return $output;
    }

}
