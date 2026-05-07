<!DOCTYPE html>
<html>
<head>
    <title>Create Issue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 8px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .error {
            color: #b91c1c;
            margin-bottom: 12px;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Submit New Issue</h1>

    <a href="{{ route('issues.index') }}">← Back to Issues</a>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('issues.store') }}">
        @csrf

        <label>Title</label>
        <input type="text" name="title" value="{{ old('title') }}" required>

        <label>Description</label>
        <textarea name="description" rows="6" required>{{ old('description') }}</textarea>

        <label>Priority</label>
        <select name="priority" required>
            <option value="low">Low</option>
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
            <option value="critical">Critical</option>
        </select>

        <label>Category</label>
        <select name="category" required>
            <option value="technical">Technical</option>
            <option value="billing">Billing</option>
            <option value="account">Account</option>
            <option value="operations">Operations</option>
        </select>

        <label>Status</label>
        <select name="status" required>
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
        </select>

        <label>Due Date</label>
        <input type="datetime-local" name="due_at">

        <button type="submit">
            Submit Issue
        </button>
    </form>
</div>

</body>
</html>