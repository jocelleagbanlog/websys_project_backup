@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-bold mb-4">Register</h1>

    <form method="POST" action="{{ url('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Name</label>
            <input type="text" name="name"
                   value="{{ old('name') }}"
                   class="border rounded w-full px-2 py-1" required>
        </div>

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

        <div>
            <label class="block mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="border rounded w-full px-2 py-1" required>
        </div>

        <button type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded w-full">
            Register
        </button>
    </form>
</div>
@endsection
