<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function () {
            DB::table('recipe_list_items')->get()->each(function ($item) {
                DB::table('recipe_list_items')
                    ->where('id', $item->id)
                    ->update([
                        'recipe_id' => $item->uri,
                        'uri' => $item->recipe_id,
                    ]);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::transaction(function () {
            DB::table('recipe_list_items')->get()->each(function ($item) {
                DB::table('recipe_list_items')
                    ->where('id', $item->id)
                    ->update([
                        'recipe_id' => $item->uri,
                        'uri' => $item->recipe_id,
                    ]);
            });
        });
    }
};
