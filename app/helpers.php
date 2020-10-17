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

        $color = $value >= 75 ? 'text-pass' : ($value >= 45 ? 'text-average' : 'text-fail');

        return "$prefix$color";
    }
}

if (!function_exists('dash_case')) {
    function dash_case($value)
    {
        return preg_replace('/\s+/u', '-', $value);
    }
}

if (!function_exists('flash')) {
    /**
     * Flash a message
     *
     * @param  string|null $message
     * @param  string $level
     */
    function flash($message = null, $level = 'info')
    {
        session()->flash('flash', $message);
        session()->flash('flash_level', $level);
    }
}

if (!function_exists('success')) {
    /**
     * Flash a success message
     *
     * @param  string|null $message
     */
    function success($message = null)
    {
        session()->flash('flash', $message);
        session()->flash('flash_level', 'success');
    }
}

if (!function_exists('error')) {
    /**
     * Flash an error message
     *
     * @param  string|null $message
     */
    function error($message = null)
    {
        session()->flash('flash', $message);
        session()->flash('flash_level', 'error');
    }
}
