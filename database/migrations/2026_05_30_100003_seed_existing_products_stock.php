<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('products')
            ->where('stock', 0)
            ->update(['stock' => 100]);
    }

    public function down(): void
    {
        DB::table('products')
            ->where('stock', 100)
            ->update(['stock' => 0]);
    }
};
