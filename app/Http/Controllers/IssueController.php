<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Services\IssueAutomationService;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $query = Issue::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        return response()->json($query->latest()->get());
    }

    public function store(Request $request, IssueAutomationService $automation)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high,critical',
            'category' => 'required|string|max:100',
            'status' => 'nullable|in:open,in_progress,resolved,closed',
            'due_at' => 'nullable|date',
        ]);

        $data['status'] = $data['status'] ?? 'open';

        $automationData = $automation->processIssue($data);

        $issue = Issue::create(array_merge($data, $automationData));

        return response()->json($issue, 201);
    }

    public function show(Issue $issue)
    {
        return response()->json($issue);
    }

    public function update(Request $request, Issue $issue, IssueAutomationService $automation)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|min:10',
            'priority' => 'sometimes|required|in:low,medium,high,critical',
            'category' => 'sometimes|required|string|max:100',
            'status' => 'sometimes|required|in:open,in_progress,resolved,closed',
            'due_at' => 'nullable|date',
        ]);

        $mergedData = array_merge($issue->toArray(), $data);
        $automationData = $automation->processIssue($mergedData);

        $issue->update(array_merge($data, $automationData));

        return response()->json($issue);
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();

        return response()->json([
            'message' => 'Issue deleted successfully',
        ]);
    }
}