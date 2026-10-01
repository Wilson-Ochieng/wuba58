<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $type = $request->input('type', 'all');

        $results = collect();
        $counts = [
            'projects' => 0,
            'services' => 0,
            'posts' => 0,
            'faqs' => 0,
            'testimonials' => 0,
        ];

        if (strlen($query) >= 2) {
            $term = '%' . $query . '%';

            // ── Projects ─────────────────────────────────────────────
            if (in_array($type, ['all', 'projects'])) {
                $projects = Project::published()
                    ->with('projectCategory')
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                            ->orWhere('location', 'like', $term)
                            ->orWhere('client_name', 'like', $term)
                            ->orWhere('excerpt', 'like', $term)
                            ->orWhere('description', 'like', $term)
                            ->orWhere('scale', 'like', $term)
                            // Search related category
                            ->orWhereHas('projectCategory', function ($cat) use ($term) {
                                $cat->where('name', 'like', $term)
                                    ->orWhere('slug', 'like', $term);
                            });
                    })
                    ->orderBy('order')
                    ->get()
                    ->map(fn($p) => [
                        'type' => 'project',
                        'title' => $p->title,
                        'excerpt' => $p->excerpt ?: $p->location,
                        'url' => '/work/' . $p->slug,
                        'meta' => $p->projectCategory?->name ?? 'Project',
                        'image' => $p->hasMedia('hero') ? $p->getFirstMediaUrl('hero', 'thumb') : null,
                    ]);
                $counts['projects'] = $projects->count();
                $results = $results->merge($projects);
            }

            // ── Services ─────────────────────────────────────────────
            if (in_array($type, ['all', 'services'])) {
                $services = Service::where('published', true)
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                            ->orWhere('description', 'like', $term)
                            ->orWhere('slug', 'like', $term);
                    })
                    ->orderBy('order')
                    ->get()
                    ->map(fn($s) => [
                        'type' => 'service',
                        'title' => $s->title,
                        'excerpt' => $s->description,
                        'url' => '/services#' . $s->slug,
                        'meta' => 'Service',
                        'image' => $s->hasMedia('image') ? $s->getFirstMediaUrl('image') : null,
                    ]);
                $counts['services'] = $services->count();
                $results = $results->merge($services);
            }

            // ── Blog Posts ───────────────────────────────────────────
            if (in_array($type, ['all', 'posts'])) {
                $posts = Post::published()
                    ->with('category')
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                            ->orWhere('excerpt', 'like', $term)
                            ->orWhere('body', 'like', $term)
                            ->orWhere('slug', 'like', $term)
                            // Search related blog category
                            ->orWhereHas('category', function ($cat) use ($term) {
                                $cat->where('name', 'like', $term)
                                    ->orWhere('slug', 'like', $term);
                            });
                    })
                    ->orderByDesc('published_at')
                    ->get()
                    ->map(fn($p) => [
                        'type' => 'post',
                        'title' => $p->title,
                        'excerpt' => $p->excerpt ?: \Str::limit(strip_tags($p->body), 140),
                        'url' => '/journal/' . $p->slug,
                        'meta' => 'Journal · ' . ($p->category?->name ?? 'Article'),
                        'image' => $p->hasMedia('hero') ? $p->getFirstMediaUrl('hero', 'thumb') : null,
                    ]);
                $counts['posts'] = $posts->count();
                $results = $results->merge($posts);
            }

            // ── FAQs ─────────────────────────────────────────────────
            if (in_array($type, ['all', 'faqs'])) {
                $faqs = Faq::published()
                    ->where(function ($q) use ($term) {
                        $q->where('question', 'like', $term)
                            ->orWhere('answer', 'like', $term)
                            // Search category label
                            ->orWhere('category', 'like', $term);
                    })
                    ->orderBy('order')
                    ->get()
                    ->map(fn($f) => [
                        'type' => 'faq',
                        'title' => $f->question,
                        'excerpt' => \Str::limit($f->answer, 160),
                        'url' => '/faq#' . \Str::slug($f->question),
                        'meta' => 'FAQ · ' . (Faq::categories()[$f->category] ?? ucfirst($f->category)),
                        'image' => null,
                    ]);
                $counts['faqs'] = $faqs->count();
                $results = $results->merge($faqs);
            }

            // ── Testimonials ─────────────────────────────────────────
            if (in_array($type, ['all', 'testimonials'])) {
                $testimonials = Testimonial::published()
                    ->where(function ($q) use ($term) {
                        $q->where('author_name', 'like', $term)
                            ->orWhere('author_company', 'like', $term)
                            ->orWhere('author_role', 'like', $term)
                            ->orWhere('body', 'like', $term);
                    })
                    ->orderBy('order')
                    ->get()
                    ->map(fn($t) => [
                        'type' => 'testimonial',
                        'title' => 'A review from ' . $t->author_name,
                        'excerpt' => \Str::limit($t->body, 160),
                        'url' => '/#testimonials',
                        'meta' => 'Testimonial · ' . $t->author_company,
                        'image' => $t->author_avatar_url,
                    ]);
                $counts['testimonials'] = $testimonials->count();
                $results = $results->merge($testimonials);
            }
        }

        return view('pages.search', [
            'query' => $query,
            'type' => $type,
            'results' => $results,
            'counts' => $counts,
            'total' => $results->count(),
        ]);
    }
}