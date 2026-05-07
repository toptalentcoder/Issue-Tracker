<!DOCTYPE html>
<html>
<head>
    <title>Issue Details</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 8px;
        }

        .label {
            font-weight: bold;
            margin-top: 16px;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            background: #eee;
            margin-right: 8px;
        }

        .danger {
            color: #b91c1c;
            font-weight: bold;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">

    <a href="{{ route('issues.index') }}">← Back to Issues</a>

    <h1>{{ $issue->title }}</h1>

    <div>
        <span class="badge">{{ $issue->priority }}</span>
        <span class="badge">{{ $issue->status }}</span>
        <span class="badge">{{ $issue->category }}</span>
    </div>

    <div class="label">Description</div>
    <p>{{ $issue->description }}</p>

    <div class="label">Generated Summary</div>
    <p>{{ $issue->summary }}</p>

    <div class="label">Suggested Next Action</div>
    <p>{{ $issue->suggested_action }}</p>

    <div class="label">Escalation Status</div>

    @if($issue->escalation_required)
        <p class="danger">Escalation Required</p>
    @else
        <p>No escalation required.</p>
    @endif

    <div class="label">Due Date</div>
    <p>
        {{ $issue->due_at ? $issue->due_at->format('Y-m-d H:i') : 'Not set' }}
    </p>

    <div class="label">Created At</div>
    <p>{{ $issue->created_at }}</p>

</div>

</body>
</html>