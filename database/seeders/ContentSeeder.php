<?php

namespace Database\Seeders;

use App\Models\ClientCategory;
use App\Models\ProcessStep;
use App\Models\Service;
use App\Models\Value;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['Architectural Models', 'Physical scale models for developments, buildings and masterplans.'],
            ['Real Estate Models',   'Models designed specifically for property marketing and sales galleries.'],
            ['Masterplan Models',    'Large-scale representations of estates, cities and mixed-use developments.'],
            ['3D Visualization',     'Photorealistic renders and digital presentations.'],
            ['Illuminated Models',   'Models incorporating lighting to highlight buildings, roads and landscaping.'],
            ['Custom Models',        "Bespoke models developed around your project's specific requirements."],
        ];
        foreach ($services as $i => [$title, $desc]) {
            Service::updateOrCreate(
                ['title' => $title],
                ['slug' => \Str::slug($title), 'description' => $desc, 'order' => $i, 'published' => true]
            );
        }

        $process = [
            ['Send Your Drawings', 'Plans, elevations, renders, CAD files or concept designs.'],
            ['We Develop',         'Our team translates the project into a detailed physical/digital model.'],
            ['We Refine',          'Materials, landscaping, lighting, colours and architectural details are perfected.'],
            ['You Experience It',  'Your completed model is ready for presentations, sales galleries, exhibitions or marketing.'],
        ];
        foreach ($process as $i => [$title, $desc]) {
            ProcessStep::updateOrCreate(
                ['step_number' => $i + 1],
                ['title' => $title, 'description' => $desc, 'order' => $i]
            );
        }

        $values = [
            ['Precision',    'Detailed representation of your architectural design.'],
            ['Craft',        'Physical models built with carefully selected materials and finishes.'],
            ['Presentation', 'Models designed to communicate projects clearly to clients and stakeholders.'],
            ['Impact',       'A physical representation that makes a development easier to understand.'],
        ];
        foreach ($values as $i => [$title, $desc]) {
            Value::updateOrCreate(['title' => $title], ['description' => $desc, 'order' => $i]);
        }

        $clients = [
            'Architects', 'Property Developers', 'Real Estate Marketers',
            'Construction Companies', 'Government & Institutions',
            'Urban Planners', 'Engineering Firms',
        ];
        foreach ($clients as $i => $name) {
            ClientCategory::updateOrCreate(['name' => $name], ['order' => $i]);
        }
    }
}