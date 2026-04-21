<!-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Categories</title>
<style>
body {
    font-family:'Segoe UI', Arial, sans-serif;
    background:#f4f6f9;
    margin:0;
    display:flex;
}

.main {
    flex:1;
    padding:20px;
    margin-left:270px;
}

.form-card {
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 3px 10px rgba(0,0,0,0.05);
    width:500px;
    margin:50px auto;
}

.category-list {
    margin-top:20px;
}

.category-item {
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:white;
    padding:10px 15px;
    margin-bottom:10px;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.05);
}

.category-item span {
    cursor:pointer;
    color:red;
}
</style>
</head>
<body>
<div class="main">
    <div class="form-card">
        <h2>Categories</h2>
        <a href="{{ route('categories.create') }}" style="text-decoration:none;color:#3c8dbc;">➕ Add Category</a>

        <div class="category-list">
            @foreach($categories as $cat)
                <div class="category-item">
                    <span>📝 {{ $cat->name }} ({{ $cat->tasks->count() }})</span>
                    <form method="POST" action="{{ route('categories.delete', $cat->id) }}" onsubmit="return confirm('Delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button style="background:none;border:none;color:red;cursor:pointer;">🗑</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html> -->