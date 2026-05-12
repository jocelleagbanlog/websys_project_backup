@extends('layouts.app')

@section('title', 'Create Project')

@section('content')

<style>
    .blue {
        background: linear-gradient(135deg,#3c8dbc,#5aa9c9);
        color: white;
    }

    .blue:hover {
        opacity: 0.95;
    }

    .input {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        width: 100%;
        padding: 10px 12px;
        outline: none;
        transition: 0.2s;
    }

    .input:focus {
        border-color: #5aa9c9;
        box-shadow: 0 0 0 3px rgba(90,169,201,0.2);
    }
</style>

<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Create New Project
    </h2>

    <form method="POST" action="{{ route('projects.store') }}" class="space-y-5">
        @csrf

        {{-- NAME --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">
                Project Name
            </label>

            <input type="text"
                   name="name"
                   placeholder="Enter project name"
                   class="input"
                   required>
        </div>

        {{-- DESCRIPTION --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">
                Description
            </label>

            <textarea name="description"
                      rows="4"
                      placeholder="Enter project description"
                      class="input"></textarea>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end">

            <button type="submit"
                    class="blue px-6 py-2 rounded-lg shadow font-medium">
                Create Project
            </button>

        </div>

    </form>

</div>

@endsection