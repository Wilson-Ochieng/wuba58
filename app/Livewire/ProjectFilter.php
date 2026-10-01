<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\ProjectCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectFilter extends Component
{
    use WithPagination;

    public string $category = 'all';
    public string $search = '';

    protected $queryString = [
        'category' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];

    public function updating($field): void
    {
        if (in_array($field, ['category', 'search'])) {
            $this->resetPage();
        }
    }

    public function setCategory(string $cat): void
    {
        $this->category = $cat;
        $this->resetPage();
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Project::published()
            ->with('projectCategory')
            ->orderBy('order')
            ->orderByDesc('created_at');

        // Filter by category slug (dynamic)
        if ($this->category !== 'all') {
            $query->whereHas('projectCategory', function ($q) {
                $q->where('slug', $this->category);
            });
        }

        // Search across title, location, client, excerpt
        if (trim($this->search) !== '') {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('location', 'like', $term)
                    ->orWhere('client_name', 'like', $term)
                    ->orWhere('excerpt', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('scale', 'like', $term)
                    ->orWhere('year', 'like', $term)
                    // Search by related category name or slug
                    ->orWhereHas('projectCategory', function ($catQuery) use ($term) {
                        $catQuery->where('name', 'like', $term)
                            ->orWhere('slug', 'like', $term);
                    });
            });
        }

        $projects = $query->paginate(12);

        // Dynamic categories with counts
        $categories = ProjectCategory::where('published', true)
            ->orderBy('order')
            ->withCount([
                'projects' => fn($q) => $q->where('published', true),
            ])
            ->get();

        $totalCount = Project::published()->count();

        return view('livewire.project-filter', [
            'projects' => $projects,
            'categories' => $categories,
            'totalCount' => $totalCount,
        ]);
    }
}