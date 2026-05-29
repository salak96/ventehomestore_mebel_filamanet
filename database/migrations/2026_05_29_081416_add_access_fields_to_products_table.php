<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('access_link')->nullable()->after('description');
            $table->string('access_username')->nullable()->after('access_link');
            $table->string('access_password')->nullable()->after('access_username');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['access_link', 'access_username', 'access_password']);
        });
    }
};
