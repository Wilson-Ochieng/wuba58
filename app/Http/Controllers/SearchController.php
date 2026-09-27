<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
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
        ];

        if (strlen($query) >= 2) {
            $term = '%' . $query . '%';

            if (in_array($type, ['all', 'projects'])) {
                $projects = Project::published()
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                          ->orWhere('location', 'like', $term)
                          ->orWhere('client_name', 'like', $term)
                          ->orWhere('excerpt', 'like', $term)
                          ->orWhere('description', 'like', $term);
                    })
                    ->orderBy('order')
                    ->get()
                    ->map(fn ($p) => [
                        'type' => 'project',
                        'title' => $p->title,
                        'excerpt' => $p->excerpt ?: $p->location,
                        'url' => '/work/' . $p->slug,
                        'meta' => ucfirst(str_replace('_', ' ', $p->category)),
                        'image' => $p->hasMedia('hero') ? $p->getFirstMediaUrl('hero', 'thumb') : null,
                    ]);
                $counts['projects'] = $projects->count();
                $results = $results->merge($projects);
            }

            if (in_array($type, ['all', 'services'])) {
                $services = Service::where('published', true)
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                          ->orWhere('description', 'like', $term);
                    })
                    ->orderBy('order')
                    ->get()
                    ->map(fn ($s) => [
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

            if (in_array($type, ['all', 'posts'])) {
                $posts = Post::published()
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                          ->orWhere('excerpt', 'like', $term)
                          ->orWhere('body', 'like', $term);
                    })
                    ->orderByDesc('published_at')
                    ->get()
                    ->map(fn ($p) => [
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

            if (in_array($type, ['all', 'faqs'])) {
                $faqs = Faq::published()
                    ->where(function ($q) use ($term) {
                        $q->where('question', 'like', $term)
                          ->orWhere('answer', 'like', $term);
                    })
                    ->orderBy('order')
                    ->get()
                    ->map(fn ($f) => [
                        'type' => 'faq',
                        'title' => $f->question,
                        'excerpt' => \Str::limit($f->answer, 160),
                        'url' => '/faq#' . \Str::slug($f->question),
                        'meta' => 'FAQ',
                        'image' => null,
                    ]);
                $counts['faqs'] = $faqs->count();
                $results = $results->merge($faqs);
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