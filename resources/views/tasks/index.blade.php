<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<style>
body { 
    margin:0; 
    font-family: 'Segoe UI', Arial, sans-serif; 
    display:flex; 
    background:#f4f6f9;
}

.sidebar {
    width:230px;
    background:#3c8dbc;
    color:white;
    height:100vh;
    padding:20px;
    position:fixed; 
    top:0;
    left:0;
    overflow-y:auto;
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
    background:#3a4f57; 
    transform:translateX(5px);
}

.main { 
    flex:1; 
    padding:20px;
    margin-left:270px;
}

.topbar {
    background:white;
    padding:15px 20px;
    border-radius:12px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.btn {
    background:white;
    color:#28a745;
    padding:8px 15px;
    text-decoration:none;
    border-radius:8px;
    font-size:15px;
}

.banner {
    margin-top:20px;
    background:linear-gradient(135deg, #3c8dbc, #5aa9c9);
    color:white;
    padding:25px;
    border-radius:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.banner h2 {
    margin:0;
}

.cards {
    display:flex;
    gap:15px;
    margin-top:20px;
}

.card {
    flex:1;
    padding:20px;
    border-radius:12px;
    color:white;
    text-align:center;
    text-decoration:none;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
    transition:0.2s;
}

.card:hover {
    transform:translateY(-5px);
}

/* gradients */
.blue { background:linear-gradient(135deg,#3c8dbc,#5aa9c9); }
.green { background:linear-gradient(135deg,#28a745,#5cbf88); }
.orange { background:linear-gradient(135deg,#f39c12,#f7b267); }
.red { background:linear-gradient(135deg,#dc3545,#e57373); }

.search-box {
    margin-top:20px;
}

.search-box input {
    padding:10px;
    width:250px;
    border-radius:8px;
    border:1px solid #ddd;
}

.search-box button {
    padding:10px;
    border:none;
    background:#3c8dbc;
    color:white;
    border-radius:8px;
}

.tasks { margin-top:20px; }

.task {
    background:white;
    padding:15px;
    margin-bottom:15px;
    border-radius:12px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 3px 10px rgba(0,0,0,0.05);
}

.task-info h3 {
    margin:5px;
}

.task-info p {
    margin:5px 5px;
    color:#555;
}

.task-actions {
    text-align:right;
    margin:5px;
}

.task-actions a {
    display:inline-block;
    margin-left:10px;
    text-decoration:none;
    font-size:14px;
}

.status-completed { color:#28a745; }
.status-ongoing { color:#f39c12; }
.status-pending { color:#dc3545; }

/* category */
.category-item {
    display:flex;
    justify-content:space-between;
    align-items:center;
    /* padding:10px; */
    border-radius:8px;
    margin:5px 0;
    transition:0.2s;
}

/* .category-item:hover {
    background:#ffffff22;
} */

.category-left a {
    color:white;
    text-decoration:none;
}

/* 3-dot */
.menu {
    position:relative;
}

.menu-btn {
    cursor:pointer;
    font-size:18px;
}

/* dropdown */
.menu-content {
    display:none;
    position:absolute;
    right:0;
    background:white;
    color:black;
    min-width:120px;
    border-radius:8px;
    box-shadow:0 2px 10px rgba(0,0,0,0.2);
    z-index:1;
}

.menu-content a {
    display:block;
    padding:8px;
    margin:10px;
    text-decoration:none;
    color:black;
    text-align:center;
}

.menu-content a:hover {
    background:#f4f4f4;
}

.menu.active .menu-content {
    display:block;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px 15px;
    margin: 10px 0;
    border-radius: 8px;
    text-align: center;
    font-size: 14px;
    border-left: 5px solid #28a745;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.alert-success {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>

</head>
<body>

<body>

<div class="sidebar">
    <h2>TaskTrack</h2>

    <a href="{{ route('tasks.index') }}"><b>📋 All Tasks</b></a>

    <h4>Categories</h4>
    <!-- <a href="{{ route('categories.index') }}"><b>🗂️ Categories</b></a> -->

    <a href="{{ route('categories.create') }}" style="background:#ffffff22;">
        ➕ Add Category
    </a>
    <!-- <a href="{{ route('tasks.index',['category'=>'School']) }}">📘 School</a>
        <a href="{{ route('tasks.index',['category'=>'Work']) }}">💼 Work</a>
        <a href="{{ route('tasks.index',['category'=>'Personal']) }}">🏠 Personal</a>
        <a href="{{ route('tasks.index',['category'=>'Other']) }}">⭕ Other</a> -->

        <!-- @foreach($categories as $cat)
    <a href="{{ route('tasks.index',['category'=>$cat->id]) }}">
        📝 {{ $cat->name }} ({{ $cat->tasks->count() }})
    </a>
    @endforeach -->

    @foreach($categories as $cat)
    <div class="category-item">

        <!-- LEFT (click to filter tasks) -->
        <div class="category-left">
            <a href="{{ route('tasks.index',['category'=>$cat->id]) }}">
                📝 {{ $cat->name }} ({{ $cat->tasks->count() }})
            </a>
        </div>

    <!-- RIGHT (3-dot menu) -->
     
        <!-- <div class="menu-content">
        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
            @csrf
            @method('DELETE')
            <button type="submit" style="color:red; background:none; border:none; width:100%; text-align:center; cursor:pointer;">
                🗑 Delete
            </button>
        </form>
    </div> -->

        <div class="menu">
            <span class="menu-btn" onclick="toggleMenu(this)">⋮</span>

            <div class="menu-content">
                <a href="{{ route('categories.delete',$cat->id) }}"
                onclick="return confirm('Delete this category?')"
                style="color:red;">
                🗑 Delete
                </a>
            </div>
        </div>

    </div>
    @endforeach

    <a href="{{ route('logout') }}" style='color:#ff6b6b'>🚪 Logout</a>
    </div>

    <div class="main">

    <!-- TOPBAR -->
    <!-- <div class="topbar">
        <h3>TaskTrack</h3>
        <a href="{{ route('tasks.create') }}" class="btn">+ Create Task</a>
    </div> -->

    <!-- ✅ NEW: WELCOME BANNER -->

    @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="banner">
        <div>
            <h2>Hi, {{ session('user_name') }}</h2>
            <p>Manage your tasks efficiently today 🚀</p>  
        </div>
        <a href="{{ route('tasks.create') }}" class="btn">Create Task</a>
    </div>

    <!-- CARDS -->
    <div class="cards">
        <a href="{{ route('tasks.index') }}" class="card blue">
            <h2>{{ count($allTasks) }}</h2>
            <p>All Tasks</p>
        </a>

        <a href="{{ route('tasks.index',['filter'=>'completed']) }}" class="card green">
            <h2>{{ $allTasks->where('status','completed')->count() }}</h2>
            <p>Completed</p>
        </a>

        <a href="{{ route('tasks.index',['filter'=>'ongoing']) }}" class="card orange">
            <h2>{{ $allTasks->where('status','ongoing')->count() }}</h2>
            <p>Ongoing</p>
        </a>

        <a href="{{ route('tasks.index',['filter'=>'pending']) }}" class="card red">
            <h2>{{ $allTasks->where('status','pending')->count() }}</h2>
            <p>Pending</p>
        </a>
    </div>

    <!-- <div>
        <h4>Status</h4>

        <a class="completed" href="{{ route('tasks.index',['filter'=>'completed']) }}">
            <h2>{{ $tasks->where('status','completed')->count() }}</h2>
            <p>Completed</p>
        </a>

        <a class="ongoing" href="{{ route('tasks.index',['filter'=>'ongoing']) }}">
            <h2>{{ $tasks->where('status','ongoing')->count() }}</h2>
            <p>Ongoing</p>    
        </a>

    <a class="pending" href="{{ route('tasks.index',['filter'=>'pending']) }}">
        <h2>{{ $tasks->where('status','pending')->count() }}</h2>
        <p>Pending</p>
    </a>
    </div> -->

    <div class="search-box">
        <form method="GET" action="{{ route('tasks.index') }}">
            <input type="text" name="search" placeholder="🔍 Search task title..." value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>
        
    </div>

   

    <div class="tasks">

    @foreach($tasks as $task)
    <div class="task">

        <div class="task-info">
            <h3>{{ $task->title }}</h3>
            <p>{{ $task->description }}</p>

            <!-- <p><b>Category:</b> {{ $task->category }}</p> -->
            <!-- <p><b>Category:</b> {{ $task->category->name ?? '' }}</p> -->
        <p><b>Category:</b> {{ $task->category->name ?? 'N/A' }}</p>

            <p>
                <b>Status:</b>
                @if($task->status == 'completed')
                    <span class="status-completed">Completed</span>
                @elseif($task->status == 'ongoing')
                    <span class="status-ongoing">Ongoing</span>
                @else
                    <span class="status-pending">Pending</span>
                @endif
            </p>

            <p><b>Priority:</b>
                @if($task->priority == 'high')
                    High
                @elseif($task->priority == 'medium')
                    Medium
                @else
                    Low
                @endif
            </p>
        </div>

        <div class="task-actions">
            <a href="{{ route('tasks.edit',$task->id) }}">✏️ Edit</a>
            <!-- <a href="{{ route('tasks.delete',$task->id) }}" style="color:red;">🗑 Delete</a> -->
            <a href="{{ route('tasks.delete',$task->id) }}" 
                style="color:red;"
                onclick="return confirm('Are you sure you want to delete this task?')">
                🗑 Delete
            </a>
        </div>
    </div>
    @endforeach
    </div>
</div>
</body>

<script>
    // pag pinindot mo yung 3-dot button, magoopen menu tapos magcclose yung iba
    function toggleMenu(btn) {
        document.querySelectorAll('.menu').forEach(m => m.classList.remove('active'));
        btn.parentElement.classList.toggle('active');
    }

    // pag nagclick ka ng iba sa page, magcclose lahat ng menu
    document.addEventListener('click', function(e){
        if(!e.target.closest('.menu')){
            document.querySelectorAll('.menu').forEach(m => m.classList.remove('active'));
        }
    });
</script>
