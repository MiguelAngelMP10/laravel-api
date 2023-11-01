<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        // all, get
        $recipes = Recipe::with('category', 'tags', 'user')->get();

        return RecipeResource::collection($recipes);
    }

    public function show(Recipe $recipe): RecipeResource
    {
        $recipe = $recipe->load('category', 'tags', 'user');

        return new RecipeResource($recipe);
    }

    public function store(Request $request): JsonResponse
    {
        $recipe = Recipe::create($request->all());

        if ($tags = json_decode($request->tags)) {
            $recipe->tags()->attach($tags);
        }

        return response()->json(new RecipeResource($recipe), Response::HTTP_CREATED); // HTTP 201
    }

    public function update(Request $request, Recipe $recipe): JsonResponse
    {
        $recipe->update($request->all());

        if ($tags = json_decode($request->tags)) {
            $recipe->tags()->sync($tags);
        }

        return response()->json(new RecipeResource($recipe), Response::HTTP_OK); // 200
    }

    public function destroy()
    {
        return response()->json(null, Response::HTTP_NO_CONTENT); // 204
    }
}
