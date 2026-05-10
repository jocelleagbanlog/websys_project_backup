@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<h2 class="text-2xl mb-4 font-semibold">Create New Project</h2>

<form method="POST" action="{{ route('projects.store') }}" class="space-y-4 max-w-xl">
    @csrf
    <div>
        <label class="block mb-1 font-medium">Name</label>
        <input type="text" name="name"
               class="border rounded w-full px-3 py-2" required>
    </div>
    <div>
        <label class="block mb-1 font-medium">Description</label>
        <textarea name="description"
                  class="border rounded w-full px-3 py-2"
                  rows="3"></textarea>
    </div>
    <button class="bg-blue-500 text-white px-4 py-2 rounded shadow">
        Create
    </button>
</form>
@endsection
