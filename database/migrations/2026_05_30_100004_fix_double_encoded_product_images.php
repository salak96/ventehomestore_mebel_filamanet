<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $products = DB::table('products')->select('id', 'images')->get();

        foreach ($products as $product) {
            $raw = $product->images;
            if (is_null($raw) || $raw === '' || $raw === '[]') continue;

            $decoded = $raw;
            while (is_string($decoded)) {
                $next = json_decode($decoded, true);
                if (json_last_error() === JSON_ERROR_NONE && (is_array($next) || is_string($next))) {
                    $decoded = $next;
                } else {
                    break;
                }
            }

            if (is_array($decoded)) {
                $normalized = array_values(array_filter(
                    array_map(fn ($v) => str_replace('\\', '/', trim((string) $v)), $decoded)
                ));
                $newJson = json_encode($normalized, JSON_UNESCAPED_SLASHES);

                if ($newJson !== $raw) {
                    DB::table('products')->where('id', $product->id)->update(['images' => $newJson]);
                }
            }
        }
    }

    public function down(): void
    {
    }
};
