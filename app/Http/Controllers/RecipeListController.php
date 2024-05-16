<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecipeList;
use App\Models\RecipeListItem;
use Illuminate\Support\Facades\Auth;

class RecipeListController extends Controller
{
    public function index()
    {
        $lists = Auth::user()->recipeLists()->with('items')->get();
        return response()->json($lists);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $list = Auth::user()->recipeLists()->create([
            'name' => $request->name,
        ]);

        return response()->json($list);
    }

    public function show($id)
    {
        $list = Auth::user()->recipeLists()->with('items')->findOrFail($id);
        return response()->json($list);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $list = Auth::user()->recipeLists()->findOrFail($id);
        $list->update([
            'name' => $request->name,
        ]);

        return response()->json($list);
    }

    public function destroy($id)
    {
        $list = Auth::user()->recipeLists()->findOrFail($id);
        $list->delete();

        return response()->json(['message' => 'List deleted successfully']);
    }

    public function addRecipe(Request $request, $listId)
    {
        $request->validate([
            'recipe_id' => 'required|string',
            'recipe_name' => 'required|string',
            'recipe_image' => 'nullable|string',
        ]);

        $list = Auth::user()->recipeLists()->findOrFail($listId);

        $listRecipe = $list->items()->create([
            'recipe_id' => $request->recipe_id,
            'recipe_name' => $request->recipe_name,
            'recipe_image' => $request->recipe_image,
        ]);

        return response()->json($listRecipe);
    }

    public function removeRecipe($listId, $recipeId)
    {
        $list = Auth::user()->recipeLists()->findOrFail($listId);
        $listRecipe = $list->items()->where('recipe_id', $recipeId)->firstOrFail();
        $listRecipe->delete();

        return response()->json(['message' => 'Recipe removed from list successfully']);
    }
}
