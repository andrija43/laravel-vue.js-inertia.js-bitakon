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
        Schema::create('promptmodelrelations', function (Blueprint $table) {
            $table->foreignId('prompt_id')->constrained('prompts')->cascadeOnDelete(); // prompt id from prompts table
            $table->foreignId('promptmodel_id')->constrained('promptmodels')->cascadeOnDelete(); // model id from promptmodels table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promptmodelrelations');
    }
};
