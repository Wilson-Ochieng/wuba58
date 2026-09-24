<?php

namespace App\Livewire;

use App\Models\Project;
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
        // Reset pagination when filters change
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
            ->orderBy('order')
            ->orderByDesc('created_at');

        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        if (trim($this->search) !== '') {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('location', 'like', $term)
                    ->orWhere('client_name', 'like', $term)
                    ->orWhere('excerpt', 'like', $term);
            });
        }

        $projects = $query->paginate(12);

        // Counts per category (unfiltered, for the tab badges)
        $counts = [
            'all' => Project::published()->count(),
            'residential' => Project::published()->where('category', 'residential')->count(),
            'commercial' => Project::published()->where('category', 'commercial')->count(),
            'masterplan' => Project::published()->where('category', 'masterplan')->count(),
            'mixed_use' => Project::published()->where('category', 'mixed_use')->count(),
        ];

        return view('livewire.project-filter', [
            'projects' => $projects,
            'counts' => $counts,
        ]);
    }
}