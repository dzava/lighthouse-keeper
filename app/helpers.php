<?php

if (!function_exists('get_color_for_score')) {
    function get_color_for_score($value, $prefix = '')
    {
        if (!is_numeric($value)) {
            return '';
        }

        if ($value > 100 || $value < 0) {
            return '';
        }

        $color = $value >= 75 ? 'dark-green' : ($value >= 45 ? 'orange' : 'dark-red');

        return "$prefix$color";
    }
}
