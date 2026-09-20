<?php

namespace Database\Seeders;

use App\Models\Setting;                               // ← ADD THIS
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site.name',        'value' => 'WUBA 58 CITY MODELS', 'group' => 'general'],
            ['key' => 'site.tagline',     'value' => 'Architectural Models · 3D Visualization · Development Presentation', 'group' => 'general'],
            ['key' => 'hero.headline',    'value' => "WE TURN ARCHITECTURE\nINTO SOMETHING YOU CAN SEE.", 'group' => 'homepage', 'type' => 'textarea'],
            ['key' => 'hero.subtext',     'value' => 'Precision architectural models and 3D visualizations that bring developments to life.', 'group' => 'homepage', 'type' => 'textarea'],
            ['key' => 'contact.whatsapp', 'value' => '+254700000000', 'group' => 'contact'],
            ['key' => 'contact.phone',    'value' => '+254700000000', 'group' => 'contact'],
            ['key' => 'contact.email',    'value' => 'hello@wuba58.com', 'group' => 'contact'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s + ['type' => 'text']);
        }
    }
}