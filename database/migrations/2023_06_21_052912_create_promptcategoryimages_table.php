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
        Schema::create('promptcategoryimages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promptcategory_id')->constrained('promptcategories')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promptcategoryimages');
    }
};
