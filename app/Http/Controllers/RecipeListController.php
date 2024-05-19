<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecipeList;
use App\Models\RecipeListItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        try {
            $request->validate([
                'recipe_url' => 'required|string',
                'recipe_name' => 'required|string',
                'recipe_image' => 'nullable|string',
                'recipe_uri' => 'required|string',
            ]);
    
            $list = Auth::user()->recipeLists()->findOrFail($listId);
    
            Log::info('Adding recipe to list', [
                'list_id' => $listId,
                'recipe' => $request->all(),
                'user_id' => Auth::id()
            ]);
    
            $listRecipe = $list->items()->create([
                'recipe_url' => $request->recipe_url,
                'recipe_name' => $request->recipe_name,
                'recipe_image' => $request->recipe_image,
                'recipe_uri' => $request->recipe_uri,
                'custom_recipe_id' => md5($request->recipe_url),
            ]);
    
            return response()->json($listRecipe);
        } catch (\Exception $e) {
            Log::error('Failed to add recipe to list', [
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
    
            return response()->json(['error' => 'Failed to add recipe to list'], 500);
        }
    }

    public function removeRecipe($listId, $recipeId)
    {
        $list = Auth::user()->recipeLists()->findOrFail($listId);
        $listRecipe = $list->items()->where('custom_recipe_id', $recipeId)->firstOrFail();
        $listRecipe->delete();

        return response()->json(['message' => 'Recipe removed from list successfully']);
    }
}
