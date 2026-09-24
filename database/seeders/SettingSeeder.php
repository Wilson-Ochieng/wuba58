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
            // Site
            ['key' => 'site.name', 'value' => 'WUBA 58 CITY MODELS', 'group' => 'general'],
            ['key' => 'site.tagline', 'value' => 'Perfection · Vision · Craftsmanship · Quality', 'group' => 'general'],
            ['key' => 'site.positioning', 'value' => 'Architectural Models · 3D Visualization · Development Presentation', 'group' => 'general'],

            // Hero
            ['key' => 'hero.headline', 'value' => "WE TURN ARCHITECTURE\nINTO SOMETHING YOU CAN SEE.", 'group' => 'homepage', 'type' => 'textarea'],
            ['key' => 'hero.subtext', 'value' => 'Precision architectural models and 3D visualizations that bring developments to life.', 'group' => 'homepage', 'type' => 'textarea'],

            // Intro
            ['key' => 'intro.body', 'value' => "At Wuba 58 City Models, we build precision architectural and property scale models for developers, architects, and investors across Nairobi and beyond — turning technical drawings into tangible, sellable stories. Whether it's a single residential unit or a full master-planned development, our models help you close deals faster by giving clients the clarity that drawings and screens can't.", 'group' => 'homepage', 'type' => 'textarea'],
            ['key' => 'intro.body_2', 'value' => 'Wuba 58 City Models has 18 years of craftsmanship experience, headquartered in Shenzhen, China, with branches in Nanchang and Nairobi, Kenya. We have formed strategic partnerships with hundreds of well-known developers worldwide and have completed over 3,000 projects globally.', 'group' => 'homepage', 'type' => 'textarea'],

            // Contact
            ['key' => 'contact.phone', 'value' => '+254182466818', 'group' => 'contact'],
            ['key' => 'contact.phone_2', 'value' => '+254182466816', 'group' => 'contact'],
            ['key' => 'contact.phone_3', 'value' => '+254731138889', 'group' => 'contact'],
            ['key' => 'contact.whatsapp', 'value' => '+254731138889', 'group' => 'contact'],
            ['key' => 'contact.email', 'value' => 'wuba58informationtechnology@gmail.com', 'group' => 'contact'],
            ['key' => 'contact.address_physical', 'value' => "WUBA 58 CITY MODELS,\nKabarnet Rd, off Ngong Road,\nNairobi", 'group' => 'contact', 'type' => 'textarea'],
            ['key' => 'contact.address_postal', 'value' => "P.O BOX 13575-00800,\nNairobi", 'group' => 'contact', 'type' => 'textarea'],

            // Social
            ['key' => 'social.instagram', 'value' => 'https://www.instagram.com/wubasandmodelscoltd', 'group' => 'social'],
            ['key' => 'social.facebook', 'value' => 'https://www.facebook.com/share/1DSLxm8jUo/', 'group' => 'social'],
            ['key' => 'social.tiktok', 'value' => 'https://www.tiktok.com/@wuba.58.city.mode', 'group' => 'social'],
            ['key' => 'social.youtube', 'value' => '', 'group' => 'social'],
            ['key' => 'social.linkedin', 'value' => '', 'group' => 'social'],

            // About
            ['key' => 'about.headline', 'value' => '18 years of meticulous craftsmanship.', 'group' => 'about'],
            ['key' => 'about.body', 'value' => 'Wuba 58 City Models is a tier-1 architectural model maker headquartered in Shenzhen, China, with branches in Nanchang and Nairobi. We combine precision physical model-making with 3D visualization and development presentation — helping developers, architects, and investors communicate their vision with clarity and confidence.', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'about.partners', 'value' => "China Vanke | Poly Developments | Kaisa Group | Agile Group | Gemdale | Jinmao | New World China | Huafa Group | OCT Group | Greentown | Excellence Group | Nanchong Group | Sunshine City | China Railway | Yuexiu Property | Nimble Property | CIFI Holdings | China Merchants", 'group' => 'about', 'type' => 'textarea'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(
                ['key' => $s['key']],
                $s + ['type' => 'text']
            );
        }

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s + ['type' => 'text']);
        }
    }
}