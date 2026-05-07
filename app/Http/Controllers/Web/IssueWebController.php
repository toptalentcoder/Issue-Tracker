<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Services\IssueAutomationService;
use Illuminate\Http\Request;

class IssueWebController extends Controller
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

        return view('issues.index', [
            'issues' => $query->latest()->get(),
            'filters' => $request->only(['status', 'category', 'priority']),
        ]);
    }

    public function create()
    {
        return view('issues.create');
    }

    public function store(Request $request, IssueAutomationService $automation)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high,critical',
            'category' => 'required|string|max:100',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'due_at' => 'nullable|date',
        ]);

        $automationData = $automation->processIssue($data);

        Issue::create(array_merge($data, $automationData));

        return redirect()
            ->route('issues.index')
            ->with('success', 'Issue submitted successfully.');
    }

    public function show(Issue $issue)
    {
        return view('issues.show', [
            'issue' => $issue,
        ]);
    }
}