<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeList extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function items()
    {
        return $this->hasMany(RecipeListItem::class);
    }
}

