<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $tags = Tag::with('recipes.category', 'recipes.tags', 'recipes.user')->get();

        return TagResource::collection($tags);
    }

    public function show(Tag $tag): TagResource
    {
        $tag = $tag->load('recipes.category', 'recipes.tags', 'recipes.user');

        return new TagResource($tag);
    }
}
