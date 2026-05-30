<?php

if (! function_exists('formatRupiah')) {
    function formatRupiah($amount): string
    {
        if ($amount === null || $amount === '') {
            return 'Rp 0';
        }

        if (is_string($amount)) {
            $clean = preg_replace('/[^\d\.\-]/', '', $amount);
            if ($clean === '' || $clean === null) {
                return 'Rp 0';
            }
            $num = (float) $clean;
        } else {
            $num = (float) $amount;
        }

        $num = round($num);

        return 'Rp ' . number_format($num, 0, ',', '.');
    }
}

if (! function_exists('storage_url')) {
    function storage_url(?string $path): string
    {
        if (! $path) {
            return asset('images/default.png');
        }

        $path = str_replace('\\', '/', ltrim($path, '/'));

        if (request()->getHost() === parse_url(config('app.url'), PHP_URL_HOST)
            && config('app.env') === 'production') {
            return asset('storage/' . $path);
        }

        $base = rtrim(request()->getSchemeAndHttpHost(), '/');

        return $base . '/storage-serve/' . $path;
    }
}
