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
        Schema::create('payout_methods', function (Blueprint $table) {
            $table->id();
            $table->string('currency_name');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->double('min_limit', 2)->nullable();
            $table->double('max_limit', 2)->default(0);
            $table->string('delay')->nullable();
            $table->string('charge_type')->default('fixed');
            $table->double('fixed_charge', 2)->nullable();
            $table->double('percent_charge', 2)->nullable();
            $table->json('data')->nullable();
            $table->text('instruction')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_methods');
    }
};
