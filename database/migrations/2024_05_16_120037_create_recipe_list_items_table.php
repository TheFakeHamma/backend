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
        Schema::create('recipe_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_list_id')->constrained()->onDelete('cascade');
            $table->string('recipe_id');
            $table->string('recipe_name');
            $table->string('recipe_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_list_items');
    }
};
