@extends('layouts.app')

@section('content')
    <div class="container mw7">
        <div class="mt2 pt3 ">
            <div class="ph3 black-70">Edit</div>
            <div class="ph3 f3 break-all">
                <a href="{{ route('audits.show', $audit) }}" class="link black-80">{{ $audit->name }}</a>
            </div>
        </div>

        <form action="{{ route('audits.update', $audit) }}" method="POST" class="bg-white pa3 mt3">
            @csrf
            @method('PATCH')

            <div class="flex flex-column flex-row-ns items-center-ns">
                <label class="w-30 b mb2 mb0-ns" for="name">Name:</label>
                <input type="text" class="input" placeholder="Name" value="{{ old('name', $audit->name) }}"
                       name="name" id="name" required>
            </div>

            <div class="flex mt3">
                <div class="w-30">
                    <span class="b">Urls</span>
                </div>
                <div class="w-100 flex flex-column justify-between-ns">
                    <tags-input :data-tags="{{ json_encode($audit->urls) }}" :required="true"
                                type="url" name="urls[]" placeholder="Add url ..."></tags-input>
                </div>
            </div>

            <div class="flex mt3">
                <div class="w-30">
                    <span class="b">Audits</span>
                </div>
                <div class="w-100 flex flex-column justify-between-ns">
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]"
                               value="accessibility" {{ old('accessibility', $audit->accessibility) ? 'checked': '' }}>
                        Accessibility
                    </label>
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]"
                               value="best_practices" {{ old('best_practices', $audit->best_practices) ? 'checked': '' }}>
                        Best Practices
                    </label>
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]"
                               value="performance" {{ old('performance', $audit->performance) ? 'checked': '' }}>
                        Performance
                    </label>
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]"
                               value="pwa" {{ old('pwa', $audit->pwa) ? 'checked': '' }}> P.W.A
                    </label>
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]"
                               value="seo" {{ old('seo', $audit->seo) ? 'checked': '' }}> SEO
                    </label>
                </div>
            </div>

            <div class="flex flex-column flex-row-ns items-center-ns mt3">
                <label class="w-30 b mb2 mb0-ns" for="timeout">Timeout:</label>
                <input type="number" name="timeout" id="timeout" class="input"
                       min="1" value="{{ old('timeout', $audit->timeout) }}" required>
            </div>

            <div class="flex mt3">
                <div class="w-30">
                    <span class="b">Headers</span>
                    <p class="mt0">Any extra headers to be send in requests</p>
                </div>
                <div class="w-100 ">
                    <headers-editor :data-headers="{{ json_encode($audit->headers) }}"></headers-editor>
                </div>
            </div>

            <div class="flex mt3">
                <div class="w-30">
                    <span class="b">Webhook</span>
                </div>
                <div class="w-100 ">
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="webhook_enabled"
                               value="seo" {{ old('seo', $audit->webhook_enabled) ? 'checked': '' }}> Enable
                    </label>

                    <div class="flex flex-column flex-row-ns items-center-ns mt3">
                        <label class="w-30 b mb2 mb0-ns" for="webhook_branch">Branch:</label>
                        <input type="text" name="webhook_branch" id="webhook_branch" class="input"
                               value="{{ old('webhook_branch', $audit->webhook_branch) }}" required>
                    </div>

                    <div class="flex flex-column flex-row-ns items-center-ns mt3">
                        <label class="w-30 b mb2 mb0-ns" for="webhook_delay">Delay:</label>
                        <input type="number" name="webhook_delay" id="webhook_delay" class="input"
                               min="0" value="{{ old('webhook_delay', $audit->webhook_delay) }}" required>
                    </div>

                    <div class="flex flex-column flex-row-ns items-center-ns mt3">
                        <label class="w-30-ns b mb2 mb0-ns">Webhook url:</label>
                        <input type="text" class="input bn bg-transparent" disabled value="{{ route('webhooks', $audit) }}">
                    </div>
                </div>
            </div>

            <div class="flex mt3">
                <div class="w-30">
                    <span class="b">Notifications</span>
                </div>
                <div class="w-100 flex flex-column justify-between-ns">
                    <tags-input :data-tags="{{ json_encode($audit->notify_emails) }}" type="email" name="notify_emails[]"
                                placeholder="Add email ..."></tags-input>
                </div>
            </div>

            <div class="tr">
                <button class="button">
                    Update
                </button>
                <a href="{{ route('audits.show', $audit) }}" class="link ml3">Cancel</a>
            </div>
        </form>
    </div>
@stop

@push('fab-start')
    <a class="fab-button fab-button--secondary" href="{{ route('audits.show', $audit) }}">
        {{ $audit->name }}
    </a>
    <form action="{{ route('runs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="audit" value="{{ $audit->id }}">
        <button class="fab-button fab-button--secondary">Run now</button>
    </form>
@endpush
