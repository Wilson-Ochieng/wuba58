<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ProcessStep;

class ServicesController extends Controller
{
   public function index()
{
    $services = Service::where('published', true)->orderBy('order')->get();

    $grouped = [
        'scale_models'   => $services->where('group', 'scale_models')->values(),
        'visualizations' => $services->where('group', 'visualizations')->values(),
    ];

    return view('pages.services', [
        'servicesByGroup' => $grouped,
        'process'         => ProcessStep::orderBy('order')->get(),
    ]);
}
}