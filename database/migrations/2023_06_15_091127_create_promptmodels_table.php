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
        Schema::create('promptmodels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->foreignId('promptmodel_id')->nullable()->constrained('promptmodels')->nullOnDelete();
            $table->string('preview')->nullable();
            $table->string('icon')->nullable();
            $table->string('guide')->nullable(); //youtube link
            $table->boolean('accept_image')->default(false);
            $table->boolean('accept_profile_link')->default(false);
            $table->boolean('accept_image_size_measurement')->default(false);
            $table->boolean('accept_negative_prompt')->default(false);
            $table->boolean('has_submodel')->default(false);
            $table->boolean('accept_seed')->default(false);
            $table->text('meta')->nullable();
            $table->string('type')->default('parent_model');
            $table->timestamps();
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promptmodels');
    }
};
