@extends('layouts.app')

@section('title', 'Your Projects')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-semibold">Your Projects</h2>
    <a href="{{ route('projects.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded shadow">
        New Project
    </a>
</div>

@if($projects->isEmpty())
    <p>No projects yet.</p>
@else
    {{-- Like a simple Trello wall of project cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($projects as $project)
            <a href="{{ route('projects.show', $project) }}"
               class="block bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                <h3 class="font-bold text-lg mb-1">{{ $project->name }}</h3>
                <p class="text-sm text-gray-600 line-clamp-3">
                    {{ $project->description }}
                </p>
                <p class="mt-2 text-sm font-semibold">
                    Completion: {{ $project->completion_percentage }}%
                </p>
            </a>
        @endforeach
    </div>
@endif
@endsection
