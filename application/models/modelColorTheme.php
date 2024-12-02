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
        $hsl = self::calculateHsl($color);
        $l5 = intval(floor(5 * floor($hsl[2] / 5)));
        $hsl[2] = $l5 + 10;
        $colorBgLight = self::toColorString(self::calculateRgb($hsl));
        $hsl[2] = $l5 + 20;
        $colorBtnHover = self::toColorString(self::calculateRgb($hsl));
        $hsl[2] = 70;
        $colorHover = self::toColorString(self::calculateRgb($hsl));
        $hsl[2] = 95;
        $colorTableStriped = self::toColorString(self::calculateRgb($hsl));

        // Generate output
        $output = "/* Auto generated CSS for the color theme. Manual changes will be overwritten.\n";
        $output .= "   The color is set in the database setting table.\n";
        $output .= "   Color setting from the database: {$color}.\n";
        $output .= "*/\n";
        $output .= "\n";
        $output .= ".theme-text                                   {color:{$color}!important}\n";
        $output .= ".theme-bg                                     {color:#fff!important;background-color:{$color}!important}\n";
        $output .= ".theme-bg-light                               {color:#fff!important;background-color:{$colorBgLight}!important}\n";
        $output .= "\n";
        $output .= ".theme-btn                                    {color:#fff!important;background-color:{$color}!important}\n";
        $output .= ".theme-btn:hover                              {color:#fff!important;background-color:{$colorBtnHover}!important}\n";
        $output .= "\n";
        $output .= ".theme-hover:hover                            {background-color:{$colorHover}!important;}\n";
        $output .= "\n";
        $output .= ".theme-table-striped tbody tr:nth-child(even) {background-color:{$colorTableStriped}!important}\n";
        $output .= ".theme-table-hover tbody tr:hover             {background-color:{$colorHover}!important;cursor:pointer}\n";
        $output .= "\n";
        $output .= "a:link                                        {color:{$color}!important;text-decoration:none!important}\n";
        $output .= "a:visited                                     {color:{$color}!important;text-decoration:none!important}\n";
        $output .= "a:hover                                       {color:{$colorHover}!important;text-decoration:none!important}\n";
        $output .= "a:active                                      {color:{$color}!important;text-decoration:none!important}\n";
        $output .= "\n";
        $output .= ".loader                                       {border-top-color:{$color}!important}\n";

        // Write to file
        file_put_contents(DOC_ROOT . APP_STYLES_PATH . "color-theme.css", $output);
    }

    private static function calculateHsl($color)
    {
        if (str_starts_with($color, "#"))
        {
            $color = substr($color, 1);
        }
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
            $r = intval(round(255 * self::convertChannel($r, $t1, $t2)));
            $g = intval(round(255 * self::convertChannel($g, $t1, $t2)));
            $b = intval(round(255 * self::convertChannel($b, $t1, $t2)));
        }
        return [$r, $g, $b];
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
