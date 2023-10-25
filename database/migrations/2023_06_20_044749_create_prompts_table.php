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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('type')->nullable(); //prompts or collections
            $table->string('layout_type')->default('Tab'); //tab or grid
            $table->string('preview')->nullable();
            $table->text('gallery')->nullable(); //array
            $table->double('price')->nullable();
            $table->text('meta')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('promptmodel_id')->nullable()->constrained('promptmodels')->cascadeOnDelete();
            $table->foreignId('promptcategory_id')->nullable()->constrained('promptcategories')->nullOnDelete();
            $table->foreignId('collection_id')->nullable()->constrained('collections')->null();
            $table->integer('status')->default(2)->comment('2 = pending 1 active 0 disabled');
            $table->integer('total_likes')->default(0);
            $table->integer('total_views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
