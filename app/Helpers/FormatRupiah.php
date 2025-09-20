<?php

if (! function_exists('format_rupiah')) {
    function format_rupiah($angka): string
    {
        return 'Rp. ' . number_format($angka, 0, ',', '.');
    }
}