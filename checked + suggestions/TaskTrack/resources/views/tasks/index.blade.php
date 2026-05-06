<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TaskTrack</title>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TaskTrack</title>

<style>
body { 
    margin:0; 
    font-family: 'Segoe UI', Arial, sans-serif; 
    display:flex; 
    background:#f4f6f9;
}

/* SIDEBAR */
.sidebar {
    width:230px;
    background:#3c8dbc;
    color:white;
    height:100vh;
    padding:20px;
    position:fixed;
}

.sidebar a {
    display:flex;
    align-items:center;
    gap:10px;
    color:white;
    text-decoration:none;
    padding:10px;
    margin:8px 0;
    border-radius:8px;
    transition:0.2s;
}

.sidebar a:hover { 
    background:#2f6f94;
    transform:translateX(5px);
}

/* MAIN */
.main {
    flex:1;
    padding:20px;
    margin-left:270px;
}

/* BOARD */
.board {
    display:flex;
    gap:20px;
}

/* COLUMN (LIGHT BACKGROUND INSTEAD OF STRONG COLORS) */
.column {
    width:320px;
    flex-shrink:0;
    border-radius:12px;
    padding:15px;
    background:#eef2f7;
}

/* COLUMN TITLES WITH COLOR */
.column h3 {
    margin-bottom:10px;
    font-weight:600;
}

.red h3 { color:#dc3545; }
.orange h3 { color:#f39c12; }
.green h3 { color:#28a745; }

/* CARD (MAIN FOCUS) */
.card-task {
    background:white;
    color:#333;
    padding:14px;
    border-radius:12px;
    margin-bottom:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    transition:0.2s;
}

.card-task:hover {
    transform:translateY(-3px);
}

/* TEXT */
.card-task h4 {
    margin:6px 0;
    font-size:16px;
}

.card-task p {
    margin:4px 0;
    font-size:13px;
    color:#555;
}

/* LABEL */
.label {
    display:inline-block;
    padding:4px 10px;
    font-size:11px;
    border-radius:20px;
    color:white;
    margin-bottom:6px;
}

.pending { background:#dc3545; }
.ongoing { background:#f39c12; }
.complete { background:#28a745; }

/* SUBTASK */
.subtask {
    display:flex;
    align-items:center;
    gap:8px;
    font-size:13px;
    margin:3px 0;
}

/* PROGRESS */
.progress-bar {
    width:100%;
    height:6px;
    background:#eee;
    border-radius:10px;
    margin-top:6px;
}

.progress-fill {
    height:100%;
    border-radius:10px;
}

.red-fill { background:#dc3545; }
.orange-fill { background:#f39c12; }
.green-fill { background:#28a745; }

/* BUTTONS */
.task-actions {
    display:flex;
    gap:8px;
    margin-top:10px;
}

.btn {
    padding:6px 10px;
    font-size:12px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    text-decoration:none;
    display:inline-block;
}

.btn-edit {
    background:#3c8dbc;
    color:white;
}

.btn-edit:hover {
    background:#2f6f94;
}

.btn-delete {
    background:#dc3545;
    color:white;
}

.btn-delete:hover {
    background:#c82333;
}

/* ADD TASK */
.add-task {
    display:block;
    text-align:center;
    background:#dfe6ee;
    color:#333;
    padding:8px;
    border-radius:8px;
    text-decoration:none;
    margin-top:10px;
    font-size:13px;
}

.add-task:hover {
    background:#ccd6e0;
}
</style>
</head>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>TaskTrack</h2>

    <a href="{{ route('tasks.index') }}">📋 All Tasks</a>

    <h4>Categories</h4>

    <a href="{{ route('categories.create') }}">➕ Add Category</a>

    @foreach($categories as $cat)
        <a href="{{ route('tasks.index',['category'=>$cat->id]) }}">
            📝 {{ $cat->name }} ({{ $cat->tasks->count() }})
        </a>
    @endforeach

    <a href="{{ route('logout') }}" style="color:white;">🚪 Logout</a>
</div>


<!-- MAIN -->
<div class="main">

<div class="board">

<!-- PENDING -->
<div class="column red">
    <h3>Pending</h3>

    @foreach($tasks->where('status','pending') as $task)

    @php
        $total = $task->subtasks->count();
        $done = $task->subtasks->where('is_done', true)->count();
        $percent = $total ? ($done/$total)*100 : 0;
    @endphp

    <div class="card-task">

        <span class="label pending">Pending</span>

        <h4>{{ $task->title }}</h4>
        <p>{{ $task->description }}</p>
        <p><b>Category:</b> {{ $task->category->name ?? 'N/A' }}</p>

        @foreach($task->subtasks as $sub)
        <div class="subtask">
            <input type="checkbox"
                onclick="window.location='{{ route('subtask.toggle',$sub->id) }}'"
                {{ $sub->is_done ? 'checked' : '' }}>
            {{ $sub->title }}
        </div>
        @endforeach

        <small>{{ round($percent) }}% complete</small>

        <div class="progress-bar">
            <div class="progress-fill red-fill" style="width:{{ $percent }}%"></div>
        </div>

        <div class="task-actions">
            <a href="{{ route('tasks.edit',$task->id) }}" class="btn btn-edit">Update</a>
            <a href="{{ route('tasks.delete',$task->id) }}" class="btn btn-delete" onclick="return confirm('Delete?')">Delete</a>
        </div>

    </div>

    @endforeach

    <a href="{{ route('tasks.create') }}" class="add-task">+ Add Task</a>
</div>


<!-- ONGOING -->
<div class="column orange">
    <h3>Ongoing</h3>

    @foreach($tasks->where('status','ongoing') as $task)

    @php
        $total = $task->subtasks->count();
        $done = $task->subtasks->where('is_done', true)->count();
        $percent = $total ? ($done/$total)*100 : 0;
    @endphp

    <div class="card-task">

        <span class="label ongoing">Ongoing</span>

        <h4>{{ $task->title }}</h4>
        <p>{{ $task->description }}</p>
        <p><b>Category:</b> {{ $task->category->name ?? 'N/A' }}</p>

        @foreach($task->subtasks as $sub)
        <div class="subtask">
            <input type="checkbox"
                onclick="window.location='{{ route('subtask.toggle',$sub->id) }}'"
                {{ $sub->is_done ? 'checked' : '' }}>
            {{ $sub->title }}
        </div>
        @endforeach

        <small>{{ round($percent) }}% complete</small>

        <div class="progress-bar">
            <div class="progress-fill orange-fill" style="width:{{ $percent }}%"></div>
        </div>

        <div class="task-actions">
            <a href="{{ route('tasks.edit',$task->id) }}" class="btn btn-edit">Update</a>
            <a href="{{ route('tasks.delete',$task->id) }}" class="btn btn-delete" onclick="return confirm('Delete?')">Delete</a>
        </div>

    </div>

    @endforeach

    <a href="{{ route('tasks.create') }}" class="add-task">+ Add Task</a>
</div>


<!-- COMPLETE -->
<div class="column green">
    <h3>Complete</h3>

    @foreach($tasks->where('status','completed') as $task)

    @php $percent = 100; @endphp

    <div class="card-task">

        <span class="label complete">Complete</span>

        <h4>{{ $task->title }}</h4>
        <p><b>Category:</b> {{ $task->category->name ?? 'N/A' }}</p>

        @foreach($task->subtasks as $sub)
        <div class="subtask">
            <input type="checkbox" checked disabled>
            {{ $sub->title }}
        </div>
        @endforeach

        <small>{{ $percent }}% complete</small>

        <div class="progress-bar">
            <div class="progress-fill green-fill" style="width:{{ $percent }}%"></div>
        </div>

        <div class="task-actions">
            <a href="{{ route('tasks.edit',$task->id) }}" class="btn btn-edit">Update</a>
            <a href="{{ route('tasks.delete',$task->id) }}" class="btn btn-delete" onclick="return confirm('Delete?')">Delete</a>
        </div>

    </div>

    @endforeach

    <a href="{{ route('tasks.create') }}" class="add-task">+ Add Task</a>
</div>

</div>
</div>

</body>
</html>