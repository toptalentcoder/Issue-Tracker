@extends('layouts.app')

@section('title', 'Issue #'.$issue->id)

@section('content')
    <div class="max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('issues.index') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-700">
                ← Back to issues
            </a>
            <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">{{ $issue->title }}</h1>
                    <p class="mt-1 text-sm text-slate-600">Issue #{{ $issue->id }} · created {{ $issue->created_at?->diffForHumans() }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('issues.edit', $issue) }}"
                       class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('issues.destroy', $issue) }}"
                          onsubmit="return confirm('Delete this issue? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-600 focus-visible:ring-offset-2">
                            Delete
                        </button>
                    </form>

                    @if($issue->escalation_required)
                        <span class="ml-2 inline-flex items-center gap-2 rounded-full bg-rose-50 px-3 py-1.5 text-sm font-semibold text-rose-700">
                            <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                            Escalation required
                        </span>
                    @else
                        <span class="ml-2 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            No escalation
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Description</h2>
                    <p class="mt-3 whitespace-pre-wrap text-sm leading-6 text-slate-700">{{ $issue->description }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Generated summary</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-700">{{ $issue->summary ?: '—' }}</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Suggested next action</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-700">{{ $issue->suggested_action ?: '—' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Details</h2>
                    <dl class="mt-4 space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Priority</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $issue->priority }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Status</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ str_replace('_', ' ', $issue->status) }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Category</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $issue->category }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Due at</dt>
                            <dd class="text-sm font-semibold text-slate-900">
                                {{ $issue->due_at ? $issue->due_at->format('Y-m-d H:i') : 'Not set' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Updated</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $issue->updated_at }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection