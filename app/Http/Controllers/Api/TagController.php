<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(): Collection
    {
        return Tag::all();
    }

    public function show(Tag $tag): Tag
    {
        return $tag;
    }
}
