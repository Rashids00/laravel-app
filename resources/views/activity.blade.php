<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <form action="{{ route('activity.store') }}" method="POST">
            @csrf
            <input type="text" id="add" name="add" required>
            <input type="date" id="date" name="date" required>
            <input type="submit" value="Add">
        </form>

        <ul>
            @foreach($activity as $item)
                <li>
                    {{ $item->add }}
                    
                    <form action="{{ route('activity.delete', ['id' => $item->id]) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
