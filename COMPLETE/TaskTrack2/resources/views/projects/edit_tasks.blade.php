@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

<style>
.blue   { background: linear-gradient(135deg,#3c8dbc,#5aa9c9); color:white; }
.green  { background: linear-gradient(135deg,#28a745,#5cbf88); color:white; }
.orange { background: linear-gradient(135deg,#f39c12,#f7b267); color:white; }
.red    { background: linear-gradient(135deg,#dc3545,#e57373); color:white; }
</style>

<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4">Edit Task</h2>

    <form method="POST"
          action="{{ route('projects.tasks.update', [$project, $task]) }}"
          class="space-y-4">

        @csrf
        @method('PUT')

        <input type="text" name="title"
               value="{{ $task->title }}"
               class="w-full border rounded px-3 py-2">

        <textarea name="description"
                  class="w-full border rounded px-3 py-2">{{ $task->description }}</textarea>

        <div class="flex justify-end gap-2">

            <a href="{{ route('projects.show', $project) }}"
               class="red px-4 py-2 rounded">
                Cancel
            </a>

            <button class="blue px-4 py-2 rounded">
                Save
            </button>

        </div>

    </form>

</div>

@endsection