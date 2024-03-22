<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .completed label {
            text-decoration: line-through;
        }
        .container {
            max-width: 600px;
            margin:auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        
                <form action="{{ route('activity.store') }}" method="POST" class="row g-2 mb-3">
                    @csrf
                        <div class="col-sm-6">
                            <input class="form-control " type="text" id="add" name="add" placeholder="Add Activity" required>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control" type="date" id="date" name="date" required>
                        </div>    
                        <div class="col-sm-2">
                            <button class="btn btn-primary w-100" type="submit">Add</button>
                        </div> 
                </form>

                <form action="{{ route('filter') }}" method="GET" class="row g-2 mb-2">
                    <div class="col-sm-8">
                        <input class="form-control" type="date" id="date" name="date" value="{{ $selectedDate }}">
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-dark w-100" type="submit">Filter</button>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ route('activity.index') }}" class="btn btn-secondary w-100">Clear</a>
                    </div>
                </form>

                @if ($activity->count() > 0)
                    <ul class="list-unstyled">
                        @foreach ($activity as $item)
                            <li>{{ $item->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No activities found for the selected date.</p>
                @endif

        <ul class="list-group">
            @foreach($activity as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center {{ $item->status ? 'completed' : '' }}" id="activity{{ $item->id }}">
                <form id="toggleForm{{ $item->id }}" action="{{ route('activity.toggle', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="completed" value="{{ $item->status ? '0' : '1' }}">
                    <input type="checkbox" id="checkbox{{ $item->id }}" onchange="Completed({{ $item->id }})" {{ $item->status ? 'checked' : '' }}>
                </form>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center">
                        <label for="checkbox{{ $item->id }}" class="ms-2">{{ $item->add }}</label>
                        <form id="editForm{{ $item->id }}" action="{{ route('activity.update', ['id' => $item->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editId" name="id" value="{{ $item->id }}">
                            <input type="text" class="form-control me-2" id="editAdd{{ $item->id }}" name="add" value="{{ $item->add }}" style="display:none;" required>
                            <input type="date" class="form-control me-2" id="editDate{{ $item->id }}" name="date" value="{{ $item->date }}" style="display:none;" required>
                            <button type="submit" class="btn btn-success btn-sm" value="{{ $item->date }}" style="display:none;">Update</button>
                        </form>
                        </div>
                    </div>
                    <div class="text-center w-50">
                        <label>{{ $item->date }}</label>
                    </div>
                    <div>
                        
                        <button class="btn btn-info btn-sm me-2" onclick="edit({{ $item->id }})">Edit</button>
                        <form action="{{ route('activity.delete', ['id' => $item->id]) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function Completed(id) {
        var form = document.getElementById("toggleForm" + id);
        var checkbox = document.getElementById("checkbox" + id);       
        
        form.querySelector('input[name="completed"]').value = checkbox.checked ? '1' : '0';
        
        form.submit();
        
        var listItem = document.getElementById("activity" + id);
        if (!checkbox.checked) {
            listItem.classList.remove('completed');
        } else {
            listItem.classList.add('completed');
        }
    }

    function edit(id) {
        var editAdd = document.getElementById("editAdd" + id);
        var editDate = document.getElementById("editDate" + id);
        var update = document.querySelector("#editForm" + id + " button[type='submit']");
        var labelAdd = document.querySelector("#activity" + id + " label");
        var labelDate = document.querySelector("#activity" + id + " .text-center label");
        var editButton = document.querySelector("#activity" + id + " .btn-info");
        var deleteButton = document.querySelector("#activity" + id + " .btn-danger");

        if (editAdd.style.display === "none") {
            editAdd.style.display = "inline";
            editDate.style.display = "inline";
            update.style.display = "inline";
            labelAdd.style.display = "none";
            labelDate.style.display = "none";
            editButton.style.display = "none"; 
            deleteButton.style.display = "none"; 
        } else {
            editAdd.style.display = "none";
            editDate.style.display = "none";
            update.style.display = "none";
            labelAdd.style.display = "inline";
            labelDate.style.display = "inline";
            editButton.style.display = "inline"; 
            deleteButton.style.display = "inline"; 
        }
    }
    </script>
</body>
</html>
