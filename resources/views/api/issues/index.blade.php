@extends('layouts.app')

@section('title', 'API · Issues')

@section('content')
    <div class="flex flex-col gap-6">


        <form method="GET" action="{{ url('/api/issues') }}"
              class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <label class="block">
                    <span class="text-xs font-semibold text-slate-700">Status</span>
                    <select name="status"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                        <option value="">All</option>
                        @foreach(['open' => 'Open', 'in_progress' => 'In progress', 'resolved' => 'Resolved', 'closed' => 'Closed'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-xs font-semibold text-slate-700">Priority</span>
                    <select name="priority"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                        <option value="">All</option>
                        @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'critical' => 'Critical'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['priority'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-xs font-semibold text-slate-700">Category</span>
                    <select name="category"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                        <option value="">All</option>
                        @foreach(['technical' => 'Technical', 'billing' => 'Billing', 'account' => 'Account', 'operations' => 'Operations'] as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['category'] ?? '') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                        Apply
                    </button>
                    <a href="{{ url('/api/issues') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
                <div class="text-sm font-semibold text-slate-900">Results</div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Priority</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Escalation</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                    @forelse($issues as $issue)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-4 py-3">
                                <a class="font-semibold text-slate-900 hover:text-indigo-700"
                                   href="{{ url('/api/issues/'.$issue->id) }}">
                                    {{ $issue->title }}
                                </a>
                                <div class="mt-1 max-w-xl text-xs text-slate-500 line-clamp-2">{{ $issue->summary }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $issue->priority }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ str_replace('_', ' ', $issue->status) }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $issue->category }}</td>
                            <td class="px-4 py-3">
                                @if($issue->escalation_required)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                        Required
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        No
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-slate-600">
                                No issues found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
