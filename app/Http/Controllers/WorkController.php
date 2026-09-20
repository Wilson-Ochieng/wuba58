<?php

namespace App\Http\Controllers;

use App\Models\Project;

class WorkController extends Controller
{
   public function index()
{
    // 🔴 TEMPORARY DEBUG
    \Log::info('All projects: ' . \App\Models\Project::count());
    \Log::info('Published: ' . \App\Models\Project::where('published', true)->count());
    \Log::info('Scope published: ' . \App\Models\Project::published()->count());
    \Log::info('Full scope query: ' . \App\Models\Project::published()->toSql());

    $projects = Project::published()
        ->orderBy('order')
        ->orderByDesc('published_at')
        ->get();

    return view('pages.work.index', compact('projects'));
}

    public function show(string $slug)
    {
        $project = Project::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.work.show', compact('project'));
    }
}