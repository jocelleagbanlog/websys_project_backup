<!DOCTYPE html>
<html>
<head>
    <title>TaskTrack</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex">

    {{-- LEFT SIDEBAR --}}
    <aside class="w-64 bg-blue-600 text-white flex flex-col">
        <div class="p-4 border-b border-blue-500">
            <div class="text-2xl font-bold">TaskTrack</div>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="block px-3 py-2 rounded hover:bg-blue-500">
                    🏠 Dashboard
                </a>

                <a href="{{ route('projects.create') }}"
                   class="block px-3 py-2 rounded hover:bg-blue-500">
                    ➕ New Project
                </a>
            @endauth
        </nav>

        <div class="p-4 border-t border-blue-500">
            @auth
                <div class="mb-2 text-sm">
                    Welcome, {{ auth()->user()->name }}!
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded text-sm">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="block w-full text-center bg-white text-blue-600 py-2 rounded mb-2 text-sm">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="block w-full text-center bg-white text-blue-600 py-2 rounded text-sm">
                    Register
                </a>
            @endauth
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1">
        <header class="bg-white shadow p-4 mb-4">
            <h1 class="text-xl font-semibold">@yield('title', 'TaskTrack')</h1>
        </header>

        <div class="container mx-auto px-4 pb-8">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</div>
</body>
</html>
