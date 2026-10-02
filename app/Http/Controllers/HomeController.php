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
            'hero' => [
                'eyebrow' => Setting::get('hero.eyebrow', 'Nairobi · Shenzhen · Nanchang'),
                'headline' => Setting::get('hero.headline', "WE TURN ARCHITECTURE\nINTO SOMETHING YOU CAN SEE."),
                'headline_accent' => Setting::get('hero.headline_accent', 'SOMETHING YOU CAN SEE.'),
                'subtext' => Setting::get('hero.subtext', 'Precision architectural models and 3D visualizations that bring developments to life.'),
                'primary_cta' => [
                    'label' => Setting::get('hero.primary_cta_label', 'Explore Our Work'),
                    'url' => Setting::get('hero.primary_cta_url', '/work'),
                ],
                'secondary_cta' => [
                    'label' => Setting::get('hero.secondary_cta_label', 'Start a Project'),
                    'url' => Setting::get('hero.secondary_cta_url', '/contact'),
                ],
            ],
            'services' => Service::where('published', true)->orderBy('order')->get(),
            'process' => ProcessStep::orderBy('order')->get(),
            'featured' => Project::published()->where('featured', true)->orderBy('order')->take(4)->get(),
            'values' => Value::orderBy('order')->get(),
            'clients' => ClientCategory::orderBy('order')->get(),
        ]);
    }
}