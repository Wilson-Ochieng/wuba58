<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ProcessStep;

class ServicesController extends Controller
{
    public function index()
    {
        return view('pages.services', [
            'services' => Service::where('published', true)->orderBy('order')->get(),
            'process'  => ProcessStep::orderBy('order')->get(),
        ]);
    }
}