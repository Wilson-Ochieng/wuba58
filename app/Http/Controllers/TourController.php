<?php

namespace App\Http\Controllers;

use App\Models\TourScene;

class TourController extends Controller
{
    public function index()
    {
        $scenes = TourScene::orderBy('order')->with(['hotspots', 'media'])->get();
        $startScene = $scenes->firstWhere('is_start', true) ?? $scenes->first();

        return view('pages.work.tour', compact('scenes', 'startScene'));
    }
}