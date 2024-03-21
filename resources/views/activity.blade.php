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

    </style>
</head>
<body>
    <div class="container mt-5">
        
                <form action="{{ route('activity.store') }}" method="POST" class="row g-2 mb-2">
                    @csrf
                        <div class="col-6">
                            <input class="form-control " type="text" id="add" name="add" placeholder="Add Activity" required>
                        </div>
                        <div class="col-4">
                            <input class="form-control" type="date" id="date" name="date" required>
                        </div>    
                        <div class="col-2">
                            <button class="btn btn-primary w-100" type="submit">Add</button>
                        </div>
                    
                    
                </form>
        

        <ul class="list-group">
            @foreach($activity as $item)
            <li class="list-group-item d-flex justify-content-between align-items-center {{ $item->status ? 'completed' : '' }}" id="activity-{{ $item->id }}">
                <form id="toggleForm-{{ $item->id }}" action="{{ route('activity.toggle', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="completed" value="{{ $item->status ? '0' : '1' }}">
                    <input type="checkbox" id="checkbox-{{ $item->id }}" onchange="Completed({{ $item->id }})" {{ $item->status ? 'checked' : '' }}>
                </form>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center">
                        <label for="checkbox-{{ $item->id }}" class="ms-2">{{ $item->add }}</label>
                        </div>
                    </div>
                    <div class="text-center w-50">
                        <label>{{ $item->date }}</label>
                    </div>
                    <div>
                        <button class="btn btn-info btn-sm me-2" onclick="editActivity({{ $item->id }}, '{{ $item->add }}', '{{ $item->date }}')">Edit</button>
                        <form id="editForm-{{ $item->id }}" action="{{ route('activity.update', ['id' => $item->id]) }}" method="POST" style="display:none;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editId" name="id">
                            <input type="text" class="form-control me-2" id="editAdd" name="add" required>
                            <input type="date" class="form-control me-2" id="editDate" name="date" required>
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </form>
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
        var form = document.getElementById("toggleForm-" + id);
        var checkbox = document.getElementById("checkbox-" + id);       
        
        form.querySelector('input[name="completed"]').value = checkbox.checked ? '1' : '0';
        
        form.submit();
        
        var listItem = document.getElementById("activity-" + id);
        if (!checkbox.checked) {
            listItem.classList.remove('completed');
        } else {
            listItem.classList.add('completed');
        }
    }

        function editActivity(id, add, date) {
            var editForm = document.getElementById("editForm-" + id);
            editForm.querySelector("#editId").value = id;
            editForm.querySelector("#editAdd").value = add;
            editForm.querySelector("#editDate").value = date;
            editForm.style.display = "block";
        }
    </script>
</body>
</html>
