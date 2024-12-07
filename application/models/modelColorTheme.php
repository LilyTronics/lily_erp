<?php

class ModelColorTheme
{

    public static function generateTheme()
    {
        // In case the configuration is not created yet, we cannot create a theme from the database
        $color = DEFAULT_COLOR;
        if (ModelSetup::checkConfiguration(true))
        {
            $table = new ModelDatabaseTableSetting();
            $settings = $table->getSettings();
            $color = (isset($settings["theme_color"]) ? $settings["theme_color"] : $color);
        }

        // Generate colors
        $result = self::getThemeColors($color);

        // Generate output
        $output = "/* Auto generated CSS for the color theme. Manual changes will be overwritten.\n";
        $output .= "   The color is set in the database setting table.\n";
        $output .= "   Color setting from the database: {$color}.\n";
        $output .= "*/\n";
        $output .= "\n";
        $output .= ".theme-text                                   {color:{$color}!important}\n";
        $output .= ".theme-bg                                     {color:#fff!important;background-color:{$color}!important}\n";
        $output .= ".theme-bg-light                               {color:#fff!important;background-color:{$result["theme_bg_light"]}!important}\n";
        $output .= "\n";
        $output .= ".theme-btn                                    {color:#fff!important;background-color:{$color}!important}\n";
        $output .= ".theme-btn:hover                              {color:#fff!important;background-color:{$result["theme_btn_hover"]}!important}\n";
        $output .= "\n";
        $output .= ".theme-hover:hover                            {background-color:{$result["theme_hover"]}!important;}\n";
        $output .= "\n";
        // No important used here for text color. That will not work if a link is styled as button.
        $output .= "a:link                                        {color:{$color};text-decoration:none!important}\n";
        $output .= "a:visited                                     {color:{$color};text-decoration:none!important}\n";
        $output .= "a:hover                                       {color:{$result["theme_hover"]};text-decoration:none!important}\n";
        $output .= "a:active                                      {color:{$color};text-decoration:none!important}\n";
        $output .= "\n";
        $output .= ".loader                                       {border-top-color:{$color}!important}\n";

        // Write to file
        file_put_contents(DOC_ROOT . APP_STYLES_PATH . "color-theme.css", $output);
    }

    public static function getThemeColors($color)
    {
        $result = ["result" => false, "message" => "No color specified"];
        if ($color == "")
        {
            return $result;
        }
        if (str_starts_with($color, "#"))
        {
            $color = substr($color, 1);
        }
        $result = ["result" => false, "message" => "Invalid color specified: '{$color}'"];
        if (strlen($color) != 6)
        {
            return $result;
        }
        if (preg_match_all("/[^a-f0-9]/i", $color) > 0)
        {
            return $result;
        }
        $result = ["result" => false, "message" => "Conversion failed"];
        try
        {
            $result["theme_bg"] = "#{$color}";
            $hsl = self::calculateHsl($color);
            $l5 = intval(floor(5 * floor($hsl[2] / 5)));
            $hsl[2] = $l5 + 10;
            $result["theme_bg_light"] = self::toColorString(self::calculateRgb($hsl));
            $hsl[2] = $l5 + 20;
            $result["theme_btn_hover"] = self::toColorString(self::calculateRgb($hsl));
            $hsl[2] = 70;
            $result["theme_hover"] = self::toColorString(self::calculateRgb($hsl));
            $result["result"] = true;
            $result["message"] = "";
        }
        catch (Exception $e)
        {
            $result["message"] = "Conversion failed: " . $e->getMessage();
        }
        return $result;
    }

    private static function calculateHsl($color)
    {
        $r = hexdec(substr($color, 0, 2)) / 255;
        $g = hexdec(substr($color, 2, 2)) / 255;
        $b = hexdec(substr($color, 4, 2)) / 255;
        $h = 0;
        $s = 0;
        $l = 0;
        $min = min([$r, $g, $b]);
        $max = max([$r, $g, $b]);
        $diff = $max - $min;
        $sum = $max + $min;
        $l = $sum / 2;
        if ($min != $max)
        {
            if ($l > 0.5)
            {
                $s = $diff / (2 - $sum);
            }
            else
            {
                $s = $diff / $sum;
            }
        }
        if ($diff != 0)
        {
            if ($r == $max)
            {
                $h = ($g - $b) / $diff;
            }
            if ($g == $max)
            {
                $h = 2 + ($b - $r) / $diff;
            }
            if ($b == $max)
            {
                $h = 4 + ($r - $g) / $diff;
            }
        }
        $h = intval(round(60 * $h));
        $s = intval(round(100 * $s));
        $l = intval(round(100 * $l));
        if ($h < 0)
        {
            $h += 360;
        }
        return [$h, $s, $l];
    }

    private static function calculateRgb($hsl)
    {
        $h = $hsl[0] / 360;
        $s = $hsl[1] / 100;
        $l = $hsl[2] / 100;
        $r = 0;
        $g = 0;
        $b = 0;

        if ($s == 0)
        {
            $r = 255 * $l;
            $g = $r;
            $b = $r;
        }
        else
        {
            $t1 = 0;
            if ($l < 0.5)
            {
                $t1 = $l * (1 + $s);
            }
            else
            {
                $t1 = $l + $s - $l * $s;
            }
            $t2 = 2 * $l - $t1;
            $r = self::normalize($h + 1 / 3);
            $g = $h;
            $b = self::normalize($h - 1 / 3);
            $r = 255 * self::convertChannel($r, $t1, $t2);
            $g = 255 * self::convertChannel($g, $t1, $t2);
            $b = 255 * self::convertChannel($b, $t1, $t2);
        }
        return [intval(round($r)), intval(round($g)), intval(round($b))];
    }

    private static function normalize($value)
    {
        if ($value > 1)
        {
            $value--;
        }
        if ($value < 0)
        {
            $value++;
        }
        return $value;
    }

    private static function convertChannel($value, $t1, $t2)
    {
        if (6 * $value < 1)
        {
            return $t2 + ($t1 - $t2) * 6 * $value;
        }
        if (2 * $value < 1)
        {
            return $t1;
        }
        if (3 * $value < 2)
        {
            return $t2 + ($t1 - $t2) * ((2 / 3) - $value) * 6;
        }
        return $t2;
    }

    private static function toColorString($rgb)
    {
        $r = str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $g = str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $b = str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
        return "#{$r}{$g}{$b}";
    }

}
