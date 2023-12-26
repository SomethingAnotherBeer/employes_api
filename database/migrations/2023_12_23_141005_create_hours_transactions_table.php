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
        Schema::create('hours_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->references('id')->on('users');
            $table->integer('worked_hours')->unsigned();
            $table->boolean('is_done')->default(false);
            $table->date('hours_transaction_created');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hours_transactions');
    }
};
