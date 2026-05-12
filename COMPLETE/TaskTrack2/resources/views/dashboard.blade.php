{{-- resources/views/projects/index.blade.php --}}

@extends('layouts.app')

@section('title')
    <div class="mb-2 text-md">
        Welcome, {{ auth()->user()->name }}!
    </div>
@endsection

@section('content')

<style>
    .blue {
        background: linear-gradient(135deg,#3c8dbc,#5aa9c9);
        color: white;
    }

    .red {
        background: linear-gradient(135deg,#dc3545,#e57373);
        color: white;
    }

    .blue:hover, .red:hover {
        opacity: 0.9;
    }
</style>

<div class="w-full">

    <div class="flex justify-between items-center mb-6 w-full">

        <div class="w-full">

            <h2 class="text-2xl font-bold text-gray-800">
                Your Projects
            </h2>

            <p class="text-sm text-gray-500 mb-4">
                Manage all your projects here
            </p>

            {{-- SEARCH --}}
            <form method="GET" action="{{ url()->current() }}" class="w-full">

                <div class="flex items-center gap-2 w-full">

                    <div class="relative flex-1 w-full">

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search projects..."
                               class="w-full px-4 py-2 pl-10 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">

                        <span class="absolute left-3 top-2.5 text-gray-400">
                            🔍
                        </span>

                    </div>

                    <button type="submit"
                            class="blue px-5 py-2 rounded-lg shadow whitespace-nowrap">
                        Search
                    </button>

                </div>

            </form>

        </div>

    </div>

    {{-- EMPTY STATE --}}
    @if($projects->isEmpty())

        <div class="bg-white rounded-lg shadow p-8 text-center w-full">
            <p class="text-gray-500">
                No projects yet.
            </p>
        </div>

    @else

        {{-- PROJECT GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">

            @foreach($projects as $project)

            <div class="bg-white rounded-xl shadow hover:shadow-xl transition duration-300 relative overflow-hidden border-t-4 border-blue-400">

                {{-- THREE DOTS --}}
                <div class="absolute top-3 right-3 z-20">

                    <button onclick="toggleMenu({{ $project->id }})"
                            class="text-gray-500 hover:text-black text-2xl px-2">
                        ⋮
                    </button>

                    {{-- DROPDOWN MENU --}}
                    <div id="menu-{{ $project->id }}"
                         class="hidden absolute right-0 mt-2 w-36 bg-white border rounded-lg shadow-lg overflow-hidden">

                        <a href="{{ route('projects.edit', $project) }}"
                           class="block px-4 py-3 text-sm hover:bg-gray-100 text-blue-600">
                            Edit
                        </a>

                        <form action="{{ route('projects.destroy', $project) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this project?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="w-full text-left px-4 py-3 text-sm hover:bg-gray-100 text-red-600">
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

                {{-- PROJECT CARD --}}
                <a href="{{ route('projects.show', $project) }}"
                   class="block p-5">

                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        {{ $project->name }}
                    </h3>

                    <p class="text-sm text-gray-600 mb-4 min-h-[60px]">
                        {{ $project->description ?: 'No description available.' }}
                    </p>

                    <div class="mb-2 flex justify-between text-sm font-medium">
                        <span>Completion</span>
                        <span>{{ $project->completion_percentage }}%</span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="blue h-3 rounded-full"
                             style="width: {{ $project->completion_percentage }}%">
                        </div>
                    </div>

                </a>

            </div>

            @endforeach

        </div>

    @endif

</div>

{{-- SCRIPT --}}
<script>
    function toggleMenu(projectId) {

        document.querySelectorAll('[id^="menu-"]').forEach(menu => {
            if(menu.id !== 'menu-' + projectId){
                menu.classList.add('hidden');
            }
        });

        document.getElementById('menu-' + projectId)
            .classList.toggle('hidden');
    }

    window.addEventListener('click', function(e){
        if(!e.target.closest('button')){
            document.querySelectorAll('[id^="menu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>

@endsection