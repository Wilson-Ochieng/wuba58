<?php

namespace App\Http\Controllers;

use App\Models\ProcessStep;
use App\Models\Service;

class ProcessController extends Controller
{
    public function index()
    {
        return view('pages.process', [
            'process' => ProcessStep::orderBy('order')->get(),
            'services' => Service::where('published', true)->orderBy('order')->take(6)->get(),
        ]);
    }
}