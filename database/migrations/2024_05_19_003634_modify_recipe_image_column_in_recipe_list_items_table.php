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
        Schema::table('recipe_list_items', function (Blueprint $table) {
            $table->string('recipe_image', 2048)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_list_items', function (Blueprint $table) {
            $table->string('recipe_image', 255)->change();
        });
    }
};
