<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'recipe_name',
        'recipe_image',
        'recipe_list_id',
    ];

    public function recipeList()
    {
        return $this->belongsTo(RecipeList::class);
    }
}

