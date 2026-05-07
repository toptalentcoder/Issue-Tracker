<!DOCTYPE html>
<html>
<head>
    <title>Issue Intake System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f7f7f7; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 24px; border-radius: 8px; }
        .top { display: flex; justify-content: space-between; align-items: center; }
        .button { background: #2563eb; color: white; padding: 10px 14px; text-decoration: none; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        th, td { border-bottom: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: top; }
        select, button { padding: 8px; margin-right: 8px; }
        .badge { padding: 4px 8px; border-radius: 4px; background: #eee; }
        .danger { color: #b91c1c; font-weight: bold; }
        .success { background: #dcfce7; padding: 10px; margin-top: 16px; border-radius: 6px; }
    </style>
</head>
<body>
<div class="container">
    <div class="top">
        <h1>Issue Intake System</h1>
        <a class="button" href="{{ route('issues.create') }}">Submit Issue</a>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('issues.index') }}">
        <select name="status">
            <option value="">All Statuses</option>
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="resolved">Resolved</option>
            <option value="closed">Closed</option>
        </select>

        <select name="priority">
            <option value="">All Priorities</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
            <option value="critical">Critical</option>
        </select>

        <select name="category">
            <option value="">All Categories</option>
            <option value="technical">Technical</option>
            <option value="billing">Billing</option>
            <option value="account">Account</option>
            <option value="operations">Operations</option>
        </select>

        <button type="submit">Filter</button>
        <a href="{{ route('issues.index') }}">Reset</a>
    </form>

    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Category</th>
            <th>Summary</th>
            <th>Next Action</th>
            <th>Escalation</th>
        </tr>
        </thead>
        <tbody>
        @forelse($issues as $issue)
            <tr>
                <td>
                    <a href="{{ route('issues.show', $issue) }}">
                        {{ $issue->title }}
                    </a>
                </td>
                <td><span class="badge">{{ $issue->priority }}</span></td>
                <td>{{ $issue->status }}</td>
                <td>{{ $issue->category }}</td>
                <td>{{ $issue->summary }}</td>
                <td>{{ $issue->suggested_action }}</td>
                <td>
                    @if($issue->escalation_required)
                        <span class="danger">Required</span>
                    @else
                        No
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No issues found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>