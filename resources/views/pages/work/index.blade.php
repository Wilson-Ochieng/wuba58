@extends('layouts.app')

@section('title', 'Portfolio — Wuba 58 City Models')
@section('description', 'A curated selection of physical architectural models and digital presentations.')

@section('content')

    <x-page-hero
        label="Selected Work"
        title="Portfolio"
        description="A curated selection of physical architectural models and digital presentations delivered across East Africa."
    />

    <x-section>
        <livewire:project-filter />
    </x-section>

    <x-cta-section />

@endsection