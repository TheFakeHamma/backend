<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_list_id',
        'recipe_url',
        'recipe_name',
        'recipe_image',
        'custom_recipe_id',
        'recipe_uri',
    ];

    public function recipeList()
    {
        return $this->belongsTo(RecipeList::class);
    }
}

