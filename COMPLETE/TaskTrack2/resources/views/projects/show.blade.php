@extends('layouts.app')

@section('content')

{{-- Project header --}}
<div class="bg-white rounded-lg shadow p-4 mb-4">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold">{{ $project->name }}</h2>
            <p class="text-gray-600">{{ $project->description }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Project Completion</p>
            <p class="text-xl font-semibold">{{ $project->completion_percentage }}%</p>
        </div>
    </div>
</div>

{{-- Members + invite --}}
<div class="bg-white rounded-lg shadow p-4 mb-4 flex flex-col md:flex-row md:space-x-6">
    <div class="flex-1">
        <h3 class="font-semibold mb-2">Members</h3>
        <ul class="list-disc list-inside text-sm">
            <li>{{ $project->owner->name }} (Owner)</li>
            @foreach($project->members as $member)
                <li>{{ $member->name }} ({{ $member->email }})</li>
            @endforeach
        </ul>
    </div>

    @if(auth()->id() === $project->owner_id)
        <div class="flex-1 mt-4 md:mt-0">
            <h3 class="font-semibold mb-2">Invite User</h3>
            <form method="POST" action="{{ route('projects.members.store', $project) }}"
                  class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0">
                @csrf
                <input type="email" name="email" placeholder="User email"
                       class="border rounded px-3 py-2 flex-1" required>
                <button class="bg-green-500 text-white px-4 py-2 rounded">
                    Invite
                </button>
            </form>
        </div>
    @endif
</div>

<!-- start ng may attachment -->
{{-- Board: 3 columns like Trello --}}
<div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
    

    {{-- PENDING COLUMN --}}
    <div class="bg-gray-100 rounded-lg p-3 flex-1">
        <h3 class="font-semibold mb-2 text-red-600">Pending</h3>

        @foreach($project->tasks->where('status','pending') as $task)

        <div class="relative">

    {{-- 3 DOT BUTTON --}}
    <div class="absolute top-1 right-1 z-20">

        <button onclick="toggleTaskMenu({{ $task->id }})"
                class="text-gray-500 hover:text-black text-xl px-2">
            ⋮
        </button>

        {{-- DROPDOWN --}}
        <div id="task-menu-{{ $task->id }}"
             class="hidden absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg z-30">

            {{-- EDIT --}}
            <a href="{{ route('projects.edit_tasks', [$project, $task]) }}"
               class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                Edit
            </a>

            {{-- DELETE --}}
<form method="POST"
      action="{{ route('tasks.destroy', [$project->id, $task->id]) }}"
      onsubmit="return confirm('Delete this task?')">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
        Delete
    </button>

</form>

        </div>

    </div>

</div>
            @php $percent = $task->completion_percentage; @endphp
            <div class="bg-white rounded shadow p-3 mb-3">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs px-2 py-1 rounded-full bg-red-500 text-white">
                        Pending
                    </span>
                    <!-- @if($task->category)
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-700">
                            {{ $task->category }}
                        </span>
                    @endif -->
                </div>

                <h4 class="font-semibold text-sm">{{ $task->title }}</h4>
                <p class="text-xs text-gray-600 mb-2">{{ $task->description }}</p>

                <p class="text-xs mb-1">
                    Completion: {{ $percent }}%
                </p>
                <div class="w-full bg-gray-200 h-2 rounded">
                    <div class="h-2 rounded bg-red-500" style="width: {{ $percent }}%"></div>
                </div>

                @if($task->completed_at)
                    <p class="text-[10px] text-gray-500 mt-1">
                        Task done: {{ $task->completed_at->format('Y-m-d H:i') }}
                    </p>
                @endif

                {{-- Quick status change --}}
                <div class="flex flex-wrap gap-2 mt-2">
                    <form method="POST"
                          action="{{ route('projects.tasks.update', [$project, $task]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <!-- <input type="hidden" name="category" value="{{ $task->category }}"> -->
                        <input type="hidden" name="status" value="ongoing">
                        <button class="text-xs bg-yellow-500 text-white px-2 py-1 rounded">
                            Move to Ongoing
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('projects.tasks.update', [$project, $task]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <input type="hidden" name="category" value="{{ $task->category }}">
                        <input type="hidden" name="status" value="completed">
                        <button class="text-xs bg-green-600 text-white px-2 py-1 rounded">
                            Mark Done
                        </button>
                    </form>
                </div>

                {{-- Subtasks --}}
                <div class="mt-2 border-t pt-2">
                    <p class="text-xs font-semibold mb-1">Subtasks</p>

                    @forelse($task->subtasks as $subtask)
                        <div class="mb-1">
                            <form method="POST"
                                  action="{{ route('tasks.subtasks.update', [$task, $subtask]) }}"
                                  class="flex items-center space-x-2 text-xs">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $subtask->title }}">
                                <!-- <input type="hidden" name="description" value="{{ $subtask->description }}"> -->
                                <select name="status"
                                        class="border rounded px-1 py-0.5 text-[11px]"
                                        onchange="this.form.submit()">
                                    <option value="pending"   {{ $subtask->status=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ongoing"   {{ $subtask->status=='ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ $subtask->status=='completed' ? 'selected' : '' }}>Done</option>
                                </select>
                                <span>{{ $subtask->title }}</span>
                            </form>

                            @if($subtask->completed_at)
                                <p class="text-[10px] text-gray-500">
                                    Done: {{ $subtask->completed_at->format('Y-m-d H:i') }}
                                </p>
                            @endif

                            {{-- Attachments --}}
                            <div class="ml-4 mt-1">
                                <p class="text-[11px] font-semibold">Attachments</p>
                                <ul class="list-disc list-inside text-[11px]">
                                    @foreach($subtask->attachments as $attachment)
                                        <!-- <li>
                                            <a href="{{ asset('storage/'.$attachment->file_path) }}"
                                               target="_blank"
                                               class="text-blue-600 underline">
                                                {{ $attachment->original_name }}
                                            </a>
                                        </li> -->
                                        <li class="flex items-center justify-between gap-2">
    {{-- File link --}}
    <a href="{{ asset('storage/'.$attachment->file_path) }}"
       target="_blank"
       class="text-blue-600 underline">
        {{ $attachment->original_name }}
    </a>

    {{-- Trash button --}}
    <form method="POST"
          action="{{ route('subtasks.attachments.destroy', $attachment->id) }}"
          onsubmit="return confirm('Delete this attachment?')">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="text-red-500 hover:text-red-700 text-sm"
                title="Delete attachment">
            🗑
        </button>
    </form>
</li>
                                    @endforeach
                                </ul>
                                <form method="POST"
                                      action="{{ route('subtasks.attachments.store', $subtask) }}"
                                      enctype="multipart/form-data"
                                      class="text-[11px] mt-1">
                                    @csrf
                                    <input type="file" name="file" class="text-[11px] mb-1">
                                    <button class="bg-blue-500 text-white px-2 py-0.5 rounded">
                                        Upload
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-gray-500">No subtasks.</p>
                    @endforelse
                </div>

                {{-- Add subtask --}}
                <div class="mt-2 border-t pt-2">
                    <p class="text-xs font-semibold mb-1">Add Subtask</p>
                    <form method="POST" action="{{ route('tasks.subtasks.store', $task) }}"
                          class="space-y-1 text-xs">
                        @csrf
                        <input type="text" name="title" placeholder="Title"
                               class="border rounded w-full px-2 py-1" required>
                        <!-- <textarea name="description" placeholder="Description"
                                  class="border rounded w-full px-2 py-1" rows="2"></textarea> -->
                        <button class="bg-indigo-500 text-white px-3 py-1 rounded text-xs">
                            Add
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- Add new task in Pending column (with category) --}}
        <div class="bg-white rounded shadow p-3">
            <p class="font-semibold text-sm mb-2">Add Task</p>
            <form method="POST" action="{{ route('projects.tasks.store', $project) }}"
                  class="space-y-2 text-xs">
                @csrf
                <input type="text" name="title" placeholder="Title"
                       class="border rounded w-full px-2 py-1" required>
                <!-- <input type="text" name="category" placeholder="Category (e.g. School, Work)"
                       class="border rounded w-full px-2 py-1"> -->
                <textarea name="description" placeholder="Description"
                          class="border rounded w-full px-2 py-1" rows="2"></textarea>
                <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                    Create Task
                </button>
            </form>
        </div>
    </div>
    

    {{-- ONGOING COLUMN --}}
    <div class="bg-gray-100 rounded-lg p-3 flex-1">

        <h3 class="font-semibold mb-2 text-yellow-600">Ongoing</h3>

        @foreach($project->tasks->where('status','ongoing') as $task)

        <div class="relative">

    {{-- 3 DOT BUTTON --}}
    <div class="absolute top-1 right-1 z-20">

        <button onclick="toggleTaskMenu({{ $task->id }})"
                class="text-gray-500 hover:text-black text-xl px-2">
            ⋮
        </button>

        {{-- DROPDOWN --}}
        <div id="task-menu-{{ $task->id }}"
             class="hidden absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg z-30">

            {{-- EDIT --}}
            <a href="{{ route('projects.edit_tasks', [$project, $task]) }}"
               class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100">
                Edit
            </a>

            {{-- DELETE --}}
            <form method="POST"
                  action="{{ route('projects.destroy', [$project, $task]) }}"
                  onsubmit="return confirm('Delete this task?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                    Delete
                </button>

            </form>

        </div>

    </div>

</div>
            @php $percent = $task->completion_percentage; @endphp
            
            <div class="bg-white rounded shadow p-3 mb-3">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs px-2 py-1 rounded-full bg-yellow-500 text-white">
                        Ongoing
                    </span>
                    <!-- @if($task->category)
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-700">
                            {{ $task->category }}
                        </span>
                    @endif -->
                </div>

                <h4 class="font-semibold text-sm">{{ $task->title }}</h4>
                <p class="text-xs text-gray-600 mb-2">{{ $task->description }}</p>

                <p class="text-xs mb-1">
                    Completion: {{ $percent }}%
                </p>
                <div class="w-full bg-gray-200 h-2 rounded">
                    <div class="h-2 rounded bg-yellow-500" style="width: {{ $percent }}%"></div>
                </div>

                @if($task->completed_at)
                    <p class="text-[10px] text-gray-500 mt-1">
                        Task done: {{ $task->completed_at->format('Y-m-d H:i') }}
                    </p>
                @endif

                {{-- Quick status change --}}
                <div class="flex flex-wrap gap-2 mt-2">
                    <form method="POST"
                          action="{{ route('projects.tasks.update', [$project, $task]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <!-- <input type="hidden" name="category" value="{{ $task->category }}"> -->
                        <input type="hidden" name="status" value="pending">
                        <button class="text-xs bg-red-500 text-white px-2 py-1 rounded">
                            Move to Pending
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('projects.tasks.update', [$project, $task]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <!-- <input type="hidden" name="category" value="{{ $task->category }}"> -->
                        <input type="hidden" name="status" value="completed">
                        <button class="text-xs bg-green-600 text-white px-2 py-1 rounded">
                            Mark Done
                        </button>
                    </form>
                </div>

                {{-- Subtasks --}}
                <div class="mt-2 border-t pt-2">
                    <p class="text-xs font-semibold mb-1">Subtasks</p>

                    @forelse($task->subtasks as $subtask)
                        <div class="mb-1">
                            <form method="POST"
                                  action="{{ route('tasks.subtasks.update', [$task, $subtask]) }}"
                                  class="flex items-center space-x-2 text-xs">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $subtask->title }}">
                                <!-- <input type="hidden" name="description" value="{{ $subtask->description }}"> -->
                                <select name="status"
                                        class="border rounded px-1 py-0.5 text-[11px]"
                                        onchange="this.form.submit()">
                                    <option value="pending"   {{ $subtask->status=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ongoing"   {{ $subtask->status=='ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ $subtask->status=='completed' ? 'selected' : '' }}>Done</option>
                                </select>
                                <span>{{ $subtask->title }}</span>
                            </form>

                            @if($subtask->completed_at)
                                <p class="text-[10px] text-gray-500">
                                    Done: {{ $subtask->completed_at->format('Y-m-d H:i') }}
                                </p>
                            @endif

                            <div class="ml-4 mt-1">
                                <p class="text-[11px] font-semibold">Attachments</p>
                                <ul class="list-disc list-inside text-[11px]">
                                    @foreach($subtask->attachments as $attachment)
                                        <li class="flex items-center justify-between gap-2">
    {{-- File link --}}
    <a href="{{ asset('storage/'.$attachment->file_path) }}"
       target="_blank"
       class="text-blue-600 underline">
        {{ $attachment->original_name }}
    </a>

    {{-- Trash button --}}
    <form method="POST"
          action="{{ route('subtasks.attachments.destroy', $attachment->id) }}"
          onsubmit="return confirm('Delete this attachment?')">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="text-red-500 hover:text-red-700 text-sm"
                title="Delete attachment">
            🗑
        </button>
    </form>
</li>
                                    @endforeach
                                </ul>
                                <form method="POST"
                                      action="{{ route('subtasks.attachments.store', $subtask) }}"
                                      enctype="multipart/form-data"
                                      class="text-[11px] mt-1">
                                    @csrf
                                    <input type="file" name="file" class="text-[11px] mb-1">
                                    <button class="bg-blue-500 text-white px-2 py-0.5 rounded">
                                        Upload
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-gray-500">No subtasks.</p>
                    @endforelse
                </div>

                {{-- Add subtask --}}
                <div class="mt-2 border-t pt-2">
                    <p class="text-xs font-semibold mb-1">Add Subtask</p>
                    <form method="POST" action="{{ route('tasks.subtasks.store', $task) }}"
                          class="space-y-1 text-xs">
                        @csrf
                        <input type="text" name="title" placeholder="Title"
                               class="border rounded w-full px-2 py-1" required>
                        <!-- <textarea name="description" placeholder="Description"
                                  class="border rounded w-full px-2 py-1" rows="2"></textarea> -->
                        <button class="bg-indigo-500 text-white px-3 py-1 rounded text-xs">
                            Add
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{-- COMPLETED COLUMN --}}
    <div class="bg-gray-100 rounded-lg p-3 flex-1">
        <h3 class="font-semibold mb-2 text-green-600">Completed</h3>

        @foreach($project->tasks->where('status','completed') as $task)
        
            @php $percent = 100; @endphp
            <div class="bg-white rounded shadow p-3 mb-3">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs px-2 py-1 rounded-full bg-green-600 text-white">
                        Completed
                    </span>
                    @if($task->category)
                        <span class="text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-700">
                            {{ $task->category }}
                        </span>
                    @endif
                </div>

                <h4 class="font-semibold text-sm">{{ $task->title }}</h4>
                <p class="text-xs text-gray-600 mb-2">{{ $task->description }}</p>

                <p class="text-xs mb-1">
                    Completion: {{ $percent }}%
                </p>
                <div class="w-full bg-gray-200 h-2 rounded">
                    <div class="h-2 rounded bg-green-600" style="width: {{ $percent }}%"></div>
                </div>

                @if($task->completed_at)
                    <p class="text-[10px] text-gray-500 mt-1">
                        Task done: {{ $task->completed_at->format('Y-m-d H:i') }}
                    </p>
                @endif

                {{-- Quick move back to ongoing or pending --}}
                <div class="flex flex-wrap gap-2 mt-2">
                    <form method="POST"
                          action="{{ route('projects.tasks.update', [$project, $task]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <!-- <input type="hidden" name="category" value="{{ $task->category }}"> -->
                        <input type="hidden" name="status" value="ongoing">
                        <button class="text-xs bg-yellow-500 text-white px-2 py-1 rounded">
                            Move to Ongoing
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('projects.tasks.update', [$project, $task]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <!-- <input type="hidden" name="category" value="{{ $task->category }}"> -->
                        <input type="hidden" name="status" value="pending">
                        <button class="text-xs bg-red-500 text-white px-2 py-1 rounded">
                            Move to Pending
                        </button>
                    </form>
                </div>

                {{-- Subtasks --}}
                <div class="mt-2 border-t pt-2">
                    <p class="text-xs font-semibold mb-1">Subtasks</p>

                    @forelse($task->subtasks as $subtask)
                        <div class="mb-1">
                            <div class="flex items-center space-x-2 text-xs">
                                <input type="checkbox" checked disabled>
                                <span>{{ $subtask->title }}</span>
                            </div>

                            @if($subtask->completed_at)
                                <p class="text-[10px] text-gray-500">
                                    Done: {{ $subtask->completed_at->format('Y-m-d H:i') }}
                                </p>
                            @endif

                            <div class="ml-4 mt-1">
                                <p class="text-[11px] font-semibold">Attachments</p>
                                <ul class="list-disc list-inside text-[11px]">
                                    @foreach($subtask->attachments as $attachment)
                                        <li>
                                            <a href="{{ asset('storage/'.$attachment->file_path) }}"
                                               target="_blank"
                                               class="text-blue-600 underline">
                                                {{ $attachment->original_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-gray-500">No subtasks.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
<!-- hanggang may attachment -->
</div>

{{-- JS --}}
<script>
function toggleTaskMenu(id)
{
    document.querySelectorAll('[id^="task-menu-"]').forEach(el => {
        if (el.id !== 'task-menu-' + id) {
            el.classList.add('hidden');
        }
    });

    document.getElementById('task-menu-' + id).classList.toggle('hidden');
}

window.addEventListener('click', function(e){
    if (!e.target.closest('button')) {
        document.querySelectorAll('[id^="task-menu-"]').forEach(el => {
            el.classList.add('hidden');
        });
    }
});
</script>

@endsection


