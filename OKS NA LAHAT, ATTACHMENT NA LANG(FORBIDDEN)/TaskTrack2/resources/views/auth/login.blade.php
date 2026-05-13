@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-bold mb-4">Login</h1>

    <form method="POST" action="{{ url('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email"
                   value="{{ old('email') }}"
                   class="border rounded w-full px-2 py-1" required>
        </div>

        <div>
            <label class="block mb-1">Password</label>
            <input type="password" name="password"
                   class="border rounded w-full px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="remember"
                   id="remember" class="mr-2"
                   {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Remember me</label>
        </div>

        {{-- LOGIN BUTTON --}}
        <button type="submit"
                class="text-white px-4 py-2 rounded w-full shadow hover:opacity-90 transition"
                style="background: linear-gradient(135deg,#3c8dbc,#5aa9c9);">
            Login
        </button>
    </form>
</div>
@endsection
