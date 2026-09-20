<?php

namespace App\Http\Controllers;

use App\Models\ClientCategory;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Value;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'hero'        => [
                'headline' => Setting::get('hero.headline', "WE TURN ARCHITECTURE\nINTO SOMETHING YOU CAN SEE."),
                'subtext'  => Setting::get('hero.subtext', 'Precision architectural models and 3D visualizations.'),
            ],
            'services'    => Service::where('published', true)->orderBy('order')->get(),
            'process'     => ProcessStep::orderBy('order')->get(),
            'featured'    => Project::published()->where('featured', true)->orderBy('order')->take(4)->get(),
            'values'      => Value::orderBy('order')->get(),
            'clients'     => ClientCategory::orderBy('order')->get(),
        ]);
    }
}