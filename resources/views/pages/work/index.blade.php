@extends('layouts.app')

@section('title', 'Portfolio — WUBA 58 City Models')
@section('description', 'A curated selection of physical architectural models and digital presentations.')

@section('content')

<x-page-hero
    label="Selected Work"
    title="Portfolio"
    description="A curated selection of physical architectural models and digital presentations delivered across East Africa."
/>

<x-section>
    @if ($projects->isEmpty())
        <div class="card-elegant p-12 text-center text-charcoal-300">
            No projects published yet — add them in the admin.
        </div>
    @else
        <div class="grid md:grid-cols-2 gap-8 md:gap-10">
            @foreach ($projects as $project)
                <x-project-card :project="$project" />
            @endforeach
        </div>
    @endif
</x-section>

<x-cta-section />

@endsection