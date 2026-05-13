<!-- @extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

<div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">

    <h2 class="text-2xl font-bold mb-4">Edit Task</h2>

    <form method="POST"
          action="{{ route('projects.tasks.update', [$project, $task]) }}"
          class="space-y-4">

        @csrf
        @method('PUT')

        {{-- TITLE --}}
        <div>
            <label class="text-sm font-semibold">Title</label>
            <input type="text"
                   name="title"
                   value="{{ old('title', $task->title) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- DESCRIPTION --}}
        <div>
            <label class="text-sm font-semibold">Description</label>
            <textarea name="description"
                      class="w-full border rounded px-3 py-2"
                      rows="4">{{ old('description', $task->description) }}</textarea>
        </div>

        {{-- STATUS --}}
        <div>
            <label class="text-sm font-semibold">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ongoing" {{ $task->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        {{-- BUTTONS --}}
        <div class="flex justify-end space-x-2">

            <a href="{{ route('projects.show', $project) }}"
               class="bg-gray-400 text-white px-4 py-2 rounded">
                Cancel
            </a>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Update Task
            </button>

        </div>

    </form>

</div>

@endsection -->