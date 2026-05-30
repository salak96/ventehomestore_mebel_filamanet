<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('stock')->default(0)->after('in_stock');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('in_stock');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('in_stock')->default(true)->after('on_sale');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};
