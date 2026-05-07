@extends('layouts.app')

@section('title', 'Edit Issue')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <a href="{{ route('issues.show', $issue) }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-700">
                    ← Back to issue
                </a>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight">Edit issue</h1>
                <p class="mt-1 text-sm text-slate-600">Update details and change status as the issue progresses.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-900">
                <p class="text-sm font-semibold">Please fix the following:</p>
                <ul class="mt-2 list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('issues.update', $issue) }}"
              class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <label class="block sm:col-span-2">
                    <span class="text-xs font-semibold text-slate-700">Title</span>
                    <input type="text" name="title" value="{{ old('title', $issue->title) }}" required
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                </label>

                <label class="block sm:col-span-2">
                    <span class="text-xs font-semibold text-slate-700">Description</span>
                    <textarea name="description" rows="7" required
                              class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">{{ old('description', $issue->description) }}</textarea>
                </label>

                <label class="block">
                    <span class="text-xs font-semibold text-slate-700">Priority</span>
                    <select name="priority" required
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                        @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'critical' => 'Critical'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('priority', $issue->priority) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-xs font-semibold text-slate-700">Category</span>
                    <select name="category" required
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                        @foreach(['technical' => 'Technical', 'billing' => 'Billing', 'account' => 'Account', 'operations' => 'Operations'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('category', strtolower($issue->category)) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-xs font-semibold text-slate-700">Status</span>
                    <select name="status" required
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                        @foreach(['open' => 'Open', 'in_progress' => 'In progress', 'resolved' => 'Resolved', 'closed' => 'Closed'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $issue->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-xs font-semibold text-slate-700">Due date (optional)</span>
                    <input type="datetime-local" name="due_at"
                           value="{{ old('due_at', $issue->due_at ? $issue->due_at->format('Y-m-d\\TH:i') : '') }}"
                           class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                </label>
            </div>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('issues.show', $issue) }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2">
                    Save changes
                </button>
            </div>
        </form>
    </div>
@endsection
