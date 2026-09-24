<?php

namespace App\Http\Controllers;

use App\Models\Project;

class PhysicalModelsController extends Controller
{
    public function index()
    {
        // Only projects that have a .glb model uploaded
        $projects = Project::published()
            ->whereHas('media', fn($q) => $q->where('collection_name', 'model'))
            ->orderBy('order')
            ->get();

        return view('pages.work.physical-models', compact('projects'));
    }
}