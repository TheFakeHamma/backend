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
            $table->renameColumn('recipe_id', 'recipe_url');
            $table->renameColumn('uri', 'recipe_uri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_list_items', function (Blueprint $table) {
            $table->renameColumn('recipe_url', 'recipe_id');
            $table->renameColumn('recipe_uri', 'uri');
        });
    }
};
