@extends('layouts.app')

@section('content')

<div class="card p-3">

<h3>{{ $task->title }}</h3>

<p>{{ $task->description }}</p>

<form method="POST" action="/task/{{ $task->id }}/status">
@csrf

<select name="status" class="form-control mb-2">
    <option value="pending">Pending</option>
    <option value="ongoing">Ongoing</option>
    <option value="completed">Completed</option>
</select>

<button class="btn btn-primary">Update Status</button>
</form>

<hr>

<h5>Subtasks</h5>

@foreach($task->subtasks as $sub)
    <div class="border p-2 mb-2">

        <strong>{{ $sub->title }}</strong>
        <span class="badge bg-info">{{ $sub->status }}</span>

        <br>

        @if($sub->file)
            <a href="{{ asset('storage/'.$sub->file) }}" target="_blank">View File</a>
        @endif

    </div>
@endforeach

</div>

@endsection