<!DOCTYPE html>
<html>
<head>
    <title>TaskTrack</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        .blue {
            background: linear-gradient(135deg,#3c8dbc,#5aa9c9);
            color: white;
        }

        .red {
            background: linear-gradient(135deg,#dc3545,#e57373);
            color: white;
        }

        .blue-hover:hover {
            background: linear-gradient(135deg,#3490c1,#4fa3c5);
        }

        .red:hover {
            opacity: 0.9;
        }
        .text-blue-theme:hover {
            color: #3c8dbc;
        }
        .blue {
            background: linear-gradient(135deg,#3c8dbc,#5aa9c9);
            color: white;
        }

        .green {
            background: linear-gradient(135deg,#28a745,#5cbf88);
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex flex-col">

    {{-- TOP NAVBAR --}}
    <nav class="blue shadow-md">

        <div class="max-w-7xl mx-auto px-6">

            <div class="flex justify-between items-center h-16">

                {{-- LEFT SIDE --}}
                <div class="flex items-center gap-6">

                    {{-- LOGO --}}
                    <a href="{{ route('dashboard') }}"
                       class="text-2xl font-bold tracking-wide">
                        TaskTrack
                    </a>

                    {{-- WELCOME --}}
                    @auth
                        <div class="text-md opacity-90">
                            Welcome, {{ auth()->user()->name }}!
                        </div>
                    @endauth

                </div>

                {{-- RIGHT SIDE --}}
                <div class="flex items-center gap-3">

                    @auth

                        {{-- DASHBOARD --}}
                        <a href="{{ route('dashboard') }}"
                           class="px-3 py-2 rounded transition duration-200 hover:bg-white text-blue-theme">
                            Dashboard
                        </a>

                        {{-- ADD PROJECT --}}
                        <a href="{{ route('projects.create') }}"
                           class="px-3 py-2 rounded transition duration-200 hover:bg-white text-blue-theme">
                            + Add Project
                        </a>

                        {{-- LOGOUT --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button class="red px-4 py-2 rounded text-sm font-medium">
                                Logout
                            </button>
                        </form>

                    @else

                        <a href="{{ route('login') }}"
                           class="text-white px-4 py-2 rounded w-full shadow hover:opacity-90 transition"
                                style="background: linear-gradient(135deg,#3c8dbc,#5aa9c9);">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                           class="text-white px-4 py-2 rounded w-full shadow hover:opacity-90 transition"
                                style="background: linear-gradient(135deg,#28a745,#5cbf88);">
                            Register
                        </a>

                    @endauth

                </div>

            </div>

        </div>

    </nav>

    {{-- MAIN CONTENT --}}
    <main class="flex-1">

        <header class="bg-gray-100 p-2 mb-2">
            <!-- Optional page title -->
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