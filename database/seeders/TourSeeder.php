<?php

namespace Database\Seeders;

use App\Models\TourHotspot;
use App\Models\TourScene;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        // Wipe existing tour data (safe since it's all seedable)
        TourHotspot::truncate();
        TourScene::query()->forceDelete();

        $scenes = [
            [
                'name' => 'Reception',
                'slug' => 'reception',
                'description' => 'Welcome to our Nairobi studio — where every project begins.',
                'initial_yaw' => 0,
                'initial_pitch' => 0,
                'initial_hfov' => 110,
                'is_start' => true,
                'order' => 0,
                'image' => public_path('samples/reception.jpg'),
                'hotspots' => [
                    // (target_slug, yaw, pitch, label)
                    ['factory-floor', 60, -5, 'Enter the Factory Floor'],
                ],
            ],
            [
                'name' => 'Factory Floor',
                'slug' => 'factory-floor',
                'description' => 'Our CNC and laser-cutting area — where drawings become physical.',
                'initial_yaw' => 0,
                'initial_pitch' => 0,
                'initial_hfov' => 110,
                'is_start' => false,
                'order' => 1,
                'image' => public_path('samples/factory-floor.jpg'),
                'hotspots' => [
                    ['showroom', 120, -3, 'See the Showroom'],
                    ['reception', -100, -8, 'Back to Reception'],
                ],
            ],
            [
                'name' => 'Showroom',
                'slug' => 'showroom',
                'description' => 'Completed models on display — ready for presentations and sales galleries.',
                'initial_yaw' => 0,
                'initial_pitch' => 0,
                'initial_hfov' => 110,
                'is_start' => false,
                'order' => 2,
                'image' => public_path('samples/showroom.jpg'),
                'hotspots' => [
                    ['factory-floor', -80, -5, 'Back to Factory Floor'],
                ],
            ],
        ];

        $created = [];

        // First pass: create scenes and attach panoramas
        foreach ($scenes as $data) {
            $scene = TourScene::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'initial_yaw' => $data['initial_yaw'],
                'initial_pitch' => $data['initial_pitch'],
                'initial_hfov' => $data['initial_hfov'],
                'is_start' => $data['is_start'],
                'order' => $data['order'],
            ]);

            if (File::exists($data['image'])) {
                $scene->addMedia($data['image'])
                    ->preservingOriginal()
                    ->toMediaCollection('panorama');
            }

            $created[$data['slug']] = $scene;
        }

        // Second pass: create hotspots (now that all scenes exist)
        foreach ($scenes as $data) {
            $scene = $created[$data['slug']];

            foreach ($data['hotspots'] as $i => [$targetSlug, $yaw, $pitch, $label]) {
                if (!isset($created[$targetSlug])) {
                    continue;
                }

                TourHotspot::create([
                    'tour_scene_id' => $scene->id,
                    'target_scene_id' => $created[$targetSlug]->id,
                    'yaw' => $yaw,
                    'pitch' => $pitch,
                    'label' => $label,
                    'type' => 'scene',
                ]);
            }
        }

        $this->command->info('Seeded 3 tour scenes with sample panoramas.');
    }
}