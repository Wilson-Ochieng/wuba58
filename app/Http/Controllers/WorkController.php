<?php

namespace App\Http\Controllers;

use App\Models\Project;

class WorkController extends Controller
{
   public function index()
{
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
            $project -> load('media','hotspots');


        return view('pages.work.show', compact('project'));
    }
}