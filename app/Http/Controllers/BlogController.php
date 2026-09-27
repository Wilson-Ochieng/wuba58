<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $query = Post::published()
            ->with('category')
            ->orderByDesc('published_at');

        if ($slug = request('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $slug));
        }

        $posts = $query->paginate(9)->withQueryString();

        $featured = Post::published()
            ->with('category')
            ->where('featured', true)
            ->orderByDesc('published_at')
            ->first();

        $categories = \App\Models\PostCategory::where('published', true)
            ->orderBy('order')
            ->get();

        return view('pages.blog.index', compact('posts', 'featured', 'categories'));
    }

    public function show(string $slug)
    {
        $post = Post::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->where('post_category_id', $post->post_category_id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('pages.blog.show', compact('post', 'related'));
    }
}