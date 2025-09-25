<?php

if (! function_exists('formatRupiah')) {
    /**
     * Format angka ke Rupiah: "Rp 1.234.567"
     *
     * @param  mixed  $amount  Angka atau string (boleh mengandung titik/rp)
     * @return string
     */
    function formatRupiah($amount): string
    {
        // jika kosong/null => tampilkan Rp 0
        if ($amount === null || $amount === '') {
            return 'Rp 0';
        }

        // bersihkan string dari karakter non-numeric (kecuali minus/dot)
        if (is_string($amount)) {
            $clean = preg_replace('/[^\d\.\-]/', '', $amount);
            // fallback jika kosong setelah dibersihkan
            if ($clean === '' || $clean === null) {
                return 'Rp 0';
            }
            $num = (float) $clean;
        } else {
            $num = (float) $amount;
        }

        // bulatkan ke integer terdekat (hilangkan desimal)
        $num = round($num);

        return 'Rp ' . number_format($num, 0, ',', '.');
    }
}
