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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // user id from users table
            $table->double('amount')->nullable(); 
            $table->double('tax')->nullable(); 
            $table->string('payment_id')->nullable(); 
            $table->foreignId('gateway_id')->nullable()->constrained('gateways')->cascadeOnDelete();
            $table->text('meta')->nullable(); //address country and payment comment and screenshot if its manual payment
            $table->integer('status')->default(1); //1 = if payment complete 2 = if manual payment has submitted for review 0 = incomplete payment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
