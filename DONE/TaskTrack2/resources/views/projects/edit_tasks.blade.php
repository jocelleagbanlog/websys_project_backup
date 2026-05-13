@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

<style>
.blue   { background: linear-gradient(135deg,#3c8dbc,#5aa9c9); color:white; }
.green  { background: linear-gradient(135deg,#28a745,#5cbf88); color:white; }
.orange { background: linear-gradient(135deg,#f39c12,#f7b267); color:white; }
.red    { background: linear-gradient(135deg,#dc3545,#e57373); color:white; }
.gray   { background: #f3f4f6; }
</style>

<div class="max-w-3xl mx-auto space-y-6">

    {{-- BACK --}}
    <a href="{{ route('projects.show', $project) }}"
       class="text-blue-600 hover:underline font-semibold">
        ← Back to {{ $project->name }}
    </a>

    {{-- TASK EDIT --}}
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4">Edit Task</h2>

        <form method="POST"
              action="{{ route('projects.tasks.update', [$project, $task]) }}"
              class="space-y-4">

            @csrf
            @method('PUT')

            {{-- TITLE --}}
            <div>
                <label class="font-semibold">Title</label>
                <input type="text" name="title"
                       value="{{ old('title', $task->title) }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="font-semibold">Description</label>
                <textarea name="description"
                          class="w-full border rounded px-3 py-2"
                          rows="4">{{ old('description', $task->description) }}</textarea>
            </div>

            {{-- STATUS (NEW) --}}
            <div>
                <label class="font-semibold">Status</label>
                <select name="status"
                        class="w-full border rounded px-3 py-2">

                    <option value="pending" {{ $task->status=='pending'?'selected':'' }}>Pending</option>
                    <option value="ongoing" {{ $task->status=='ongoing'?'selected':'' }}>Ongoing</option>
                    <option value="completed" {{ $task->status=='completed'?'selected':'' }}>Completed</option>

                </select>
            </div>

            <button class="blue px-4 py-2 rounded">
                Save Task
            </button>

        </form>
    </div>

    {{-- SUBTASKS --}}
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4">Edit Subtasks</h2>

        @forelse($task->subtasks as $subtask)

            <div class="border rounded-lg p-4 mb-4 gray">

                {{-- UPDATE SUBTASK --}}
                <form method="POST"
                      action="{{ route('tasks.subtasks.update', [$task, $subtask]) }}"
                      class="space-y-3">

                    @csrf
                    @method('PUT')

                    {{-- TITLE --}}
                    <div>
                        <label class="font-semibold">Subtask Title</label>
                        <input type="text"
                               name="title"
                               value="{{ $subtask->title }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- STATUS (NEW) --}}
                    <div>
                        <label class="font-semibold">Status</label>
                        <select name="status"
                                class="w-full border rounded px-3 py-2">

                            <option value="pending" {{ $subtask->status=='pending'?'selected':'' }}>Pending</option>
                            <option value="ongoing" {{ $subtask->status=='ongoing'?'selected':'' }}>Ongoing</option>
                            <option value="completed" {{ $subtask->status=='completed'?'selected':'' }}>Completed</option>

                        </select>
                    </div>

                    <button type="submit" class="green px-3 py-2 rounded">
                        Save Changes
                    </button>
                </form>

                {{-- DELETE SUBTASK --}}
                <form method="POST"
                      action="{{ route('tasks.subtasks.destroy', [$task, $subtask]) }}"
                      onsubmit="return confirm('Delete this subtask?')"
                      class="mt-2">

                    @csrf
                    @method('DELETE')

                    <button class="red px-3 py-2 rounded text-white">
                        Delete
                    </button>

                </form>

            </div>

        @empty
            <p class="text-gray-500">No subtasks found.</p>
        @endforelse

    </div>

</div>

@endsection