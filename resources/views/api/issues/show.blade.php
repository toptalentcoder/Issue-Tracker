@extends('layouts.app')

@section('title', 'API · Issue #'.$issue->id)

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex items-center gap-2">
                <a href="{{ url('/api/issues') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                    Back to list
                </a>

                <a href="{{ route('issues.edit', $issue) }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                    Edit
                </a>

                <form method="POST" action="{{ route('issues.destroy', $issue) }}"
                      onsubmit="return confirm('Delete this issue? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Title</h2>
                    <p class="mt-2 text-base font-semibold text-slate-900">{{ $issue->title }}</p>
                </div>

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
                    <h2 class="text-sm font-semibold text-slate-900">Fields</h2>
                    <dl class="mt-4 space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">ID</dt>
                            <dd class="text-sm font-semibold text-slate-900">#{{ $issue->id }}</dd>
                        </div>
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
                            <dt class="text-sm text-slate-600">Escalation</dt>
                            <dd class="text-sm font-semibold text-slate-900">
                                {{ $issue->escalation_required ? 'Required' : 'No' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Due at</dt>
                            <dd class="text-sm font-semibold text-slate-900">
                                {{ $issue->due_at ? $issue->due_at->format('Y-m-d H:i') : 'Not set' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Created</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $issue->created_at }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-sm text-slate-600">Updated</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $issue->updated_at }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-900">Try it (curl)</h2>
                    <div class="mt-3 rounded-xl bg-slate-900 p-4 text-xs text-slate-100 overflow-x-auto text-white">
                        <pre>curl -H "Accept: application/json" {{ url('/api/issues/'.$issue->id) }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
