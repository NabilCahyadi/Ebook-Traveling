<?php

if (!function_exists('formatNumber')) {
    /**
     * Format angka menjadi bentuk yang lebih ringkas (1k, 1M).
     *
     * @param int $number
     * @return string
     */
    function formatNumber($number)
    {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 1) . 'k';
        }

        return $number;
    }
}
