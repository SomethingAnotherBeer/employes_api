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
        Schema::create('users_rates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('rate_id')->references('id')->on('rates');
            $table->decimal('payment')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_rates');
    }
};
