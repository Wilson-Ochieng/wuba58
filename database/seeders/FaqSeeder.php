<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // General
            ['general', 'What does Wuba 58 City Models do?', 'We design and build precision physical architectural models, masterplan models, real estate sales models, illuminated models, and 3D visualizations for developers, architects, urban planners, and government institutions.'],
            ['general', 'Where are you based?', 'Our headquarters is in Shenzhen, China, with branches in Nanchang, China, and Nairobi, Kenya. The Nairobi studio serves clients across East Africa.'],
            ['general', 'How long have you been in business?', 'Wuba 58 City Models has 18 years of craftsmanship experience, with more than 3,000 completed projects worldwide.'],
            ['general', 'What types of clients do you work with?', 'Architects, property developers, real estate marketers, construction companies, government institutions, urban planners, and engineering firms.'],

            // Pricing
            ['pricing', 'How much does a physical model cost?', 'Pricing depends on scale, size, level of detail, materials, lighting, and delivery timeline. Small residential models start from a modest budget, while large illuminated masterplan models require a custom quotation. Contact us with your drawings and requirements for an accurate figure.'],
            ['pricing', 'Do you charge for quotations?', 'No. Quotations and initial consultations are free. Send us your drawings and we\'ll respond within one business day.'],
            ['pricing', 'What payment terms do you offer?', 'Typically 50% deposit to begin work and 50% on delivery. Larger projects can be split into stages.'],
            ['pricing', 'Is there a minimum project size?', 'No minimum. We build single residential units as well as full masterplans.'],

            // Process
            ['process', 'How long does it take to build a model?', 'Typical timelines are 2–4 weeks for a single building model, 4–8 weeks for a residential development, and 8–14 weeks for a large masterplan with illuminated features. Timelines start when we receive your drawings and deposit.'],
            ['process', 'What do you need from me to start?', 'Drawings (CAD, PDF, or images), site plans, elevations, and any renders or mood boards you have. Also useful: purpose of the model (sales gallery, planning approval, exhibition), preferred scale, and delivery date.'],
            ['process', 'Can I make changes during production?', 'Minor changes are fine. Significant design changes after production has started may add time and cost. We share photo updates at key milestones so you can review progress.'],
            ['process', 'Do I get progress updates?', 'Yes — photos and short video updates are sent at key stages: base structure, massing, detail work, lighting, and final assembly.'],

            // Materials
            ['materials', 'What materials do you use?', 'A mix of acrylic, ABS, laser-cut MDF, basswood, photo-etched brass, resin, 3D-printed components, and hand-modeled trees and landscaping. Materials are chosen based on the look you want and the durability required.'],
            ['materials', 'Can the model be illuminated?', 'Yes. We design and program custom LED lighting that traces circulation, highlights key buildings, or simulates sunrise and night scenes. Lighting is a popular upgrade for sales gallery models.'],
            ['materials', 'Do models include landscaping?', 'Yes. Trees, grass, roads, water features, and pedestrian details are all part of our standard finish on landscape-inclusive projects.'],
            ['materials', 'How detailed can a model get?', 'As detailed as you need. We can include interior floor plans, furniture, vehicles, figurines, and building signage at very fine scales like 1:100 or 1:50.'],

            // Delivery
            ['delivery', 'Do you deliver and install?', 'Yes. Within Kenya, we deliver and install on-site, including on-site lighting commissioning if needed. International deliveries are packed in custom crates and shipped with a tracking number.'],
            ['delivery', 'How is the model protected in transit?', 'Models are packed in custom foam-lined wooden crates with protective covers. We provide unpacking instructions and can arrange on-site installation.'],
            ['delivery', 'Can you ship internationally?', 'Yes. We\'ve delivered models to clients across Asia, Africa, the Middle East, and Europe. Shipping and insurance are quoted separately.'],
            ['delivery', 'What if a model arrives damaged?', 'We photograph every model before shipping and insure deliveries. In the rare case of transit damage, we repair or rebuild at no cost.'],

            // Support
            ['support', 'Do you repair or refurbish existing models?', 'Yes. We can repair minor damage, replace lighting, refurbish landscaping, or update parts of a model to reflect a revised design.'],
            ['support', 'What warranty do you offer?', 'A 12-month warranty on lighting, electronics, and structural integrity. Physical damage from handling or transport after delivery is not covered.'],
            ['support', 'Do you offer 3D visualization as a standalone service?', 'Yes. Photorealistic renders, walkthroughs, and digital presentations can be commissioned independently of physical models.'],
            ['support', 'How do I get started?', 'Contact us via the website, WhatsApp, or email with your drawings and project details. We\'ll respond within one business day with next steps.'],
        ];

        $order = 0;
        foreach ($faqs as $i => [$category, $question, $answer]) {
            Faq::updateOrCreate(
                ['question' => $question],
                [
                    'answer' => $answer,
                    'category' => $category,
                    'order' => $order++,
                    'published' => true,
                    'featured' => $i < 4,  // first 4 on homepage
                ]
            );
        }
    }
}