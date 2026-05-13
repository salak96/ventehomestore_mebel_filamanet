<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('page_url')->nullable();
            $table->string('action')->default('view'); // view | add_to_cart
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_tracking');
    }
};
