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
            ['key' => 'hero.eyebrow', 'value' => 'Nairobi · Shenzhen · Nanchang', 'group' => 'homepage', 'type' => 'text'],
            ['key' => 'hero.headline', 'value' => "WE TURN ARCHITECTURE\nINTO SOMETHING YOU CAN SEE.", 'group' => 'homepage', 'type' => 'textarea'],
            ['key' => 'hero.headline_accent', 'value' => 'SOMETHING YOU CAN SEE.', 'group' => 'homepage', 'type' => 'text'],
            ['key' => 'hero.subtext', 'value' => 'Precision architectural models and 3D visualizations that bring developments to life.', 'group' => 'homepage', 'type' => 'textarea'],
            ['key' => 'hero.primary_cta_label', 'value' => 'Explore Our Work', 'group' => 'homepage', 'type' => 'text'],
            ['key' => 'hero.primary_cta_url', 'value' => '/work', 'group' => 'homepage', 'type' => 'text'],
            ['key' => 'hero.secondary_cta_label', 'value' => 'Start a Project', 'group' => 'homepage', 'type' => 'text'],
            ['key' => 'hero.secondary_cta_url', 'value' => '/contact', 'group' => 'homepage', 'type' => 'text'],

            // Intro
                // Section headings (dynamic)
            ['key' => 'intro.label', 'value' => '01 — Introduction', 'group' => 'homepage'],
            ['key' => 'intro.title', 'value' => "See the city before it's built.", 'group' => 'homepage'],
            ['key' => 'services.label', 'value' => '02 — What We Create', 'group' => 'homepage'],
            ['key' => 'services.title', 'value' => 'Models built to be experienced.', 'group' => 'homepage'],
            ['key' => 'process.label', 'value' => '03 — The WUBA Experience', 'group' => 'homepage'],
            ['key' => 'process.title', 'value' => 'From drawing<br>to model.', 'group' => 'homepage'],
            ['key' => 'portfolio.label', 'value' => '04 — Selected Work', 'group' => 'homepage'],
            ['key' => 'portfolio.title', 'value' => 'Portfolio', 'group' => 'homepage'],
            ['key' => 'portfolio.cta_label', 'value' => 'View All Projects', 'group' => 'homepage'],
            ['key' => 'values.label', 'value' => '05 — Why WUBA', 'group' => 'homepage'],
            ['key' => 'values.title', 'value' => 'What sets our work apart.', 'group' => 'homepage'],
            ['key' => 'beforeafter.label', 'value' => '06 — Before / After', 'group' => 'homepage'],
            ['key' => 'beforeafter.title', 'value' => 'Drawing → Model.', 'group' => 'homepage'],
            ['key' => 'beforeafter.before_label', 'value' => 'Architectural Drawing', 'group' => 'homepage'],
            ['key' => 'beforeafter.before_caption', 'value' => 'CAD / Plan', 'group' => 'homepage'],
            ['key' => 'beforeafter.after_label', 'value' => 'WUBA Model', 'group' => 'homepage'],
            ['key' => 'beforeafter.after_caption', 'value' => 'Physical Model', 'group' => 'homepage'],
            ['key' => 'clients.label', 'value' => '07 — Who We Work With', 'group' => 'homepage'],
            ['key' => 'clients.title', 'value' => 'Trusted by teams shaping<br>the built environment.', 'group' => 'homepage'],

                // Stats
            ['key' => 'stats.years', 'value' => '18', 'group' => 'homepage'],
            ['key' => 'stats.years_label', 'value' => 'Years of Craft', 'group' => 'homepage'],
            ['key' => 'stats.projects', 'value' => '3K+', 'group' => 'homepage'],
            ['key' => 'stats.projects_label', 'value' => 'Projects Worldwide', 'group' => 'homepage'],
            ['key' => 'stats.studios', 'value' => '3', 'group' => 'homepage'],
            ['key' => 'stats.studios_label', 'value' => 'Global Studios', 'group' => 'homepage'],
            ['key' => 'stats.partners', 'value' => '100s', 'group' => 'homepage'],
            ['key' => 'stats.partners_label', 'value' => 'Developer Partners', 'group' => 'homepage'],

                // Section CTAs
            ['key' => 'services.cta_whatsapp_label', 'value' => 'WhatsApp us', 'group' => 'homepage'],
            ['key' => 'services.cta_email_label', 'value' => 'Email us', 'group' => 'homepage'],
            ['key' => 'services.cta_message', 'value' => "Hi Wuba 58, I'd like to discuss a model project.", 'group' => 'homepage', 'type' => 'textarea'],
            ['key' => 'values.cta_whatsapp_label', 'value' => 'Chat on WhatsApp', 'group' => 'homepage'],
            ['key' => 'values.cta_secondary_label', 'value' => 'Start a Project →', 'group' => 'homepage'],
            ['key' => 'values.cta_secondary_url', 'value' => '/contact', 'group' => 'homepage'],

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