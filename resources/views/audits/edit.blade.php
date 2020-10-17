@extends('layouts.app')

@section('content')
    <div class="container mx-auto mw7">
        <div class="mt-2 pt-3 ">
            <div class="px-3 text-gray-700">Edit</div>
            <div class="px-3 text-2xl break-all">
                <a href="{{ route('audits.show', $audit) }}" class="text-gray-900">{{ $audit->name }}</a>
            </div>
        </div>

        <form action="{{ route('audits.update', $audit) }}" method="POST" class="bg-white p-3 mt-3">
            @csrf
            @method('PATCH')

            <div class="flex flex-col md:flex-row md:items-center border-b border-dashed py-4">
                <label class="w-1/3 b mb-2 md:mb-0" for="name">Name:</label>
                <input type="text" class="input" placeholder="Name" value="{{ old('name', $audit->name) }}"
                       name="name" id="name" required>
            </div>

            <div class="flex mt-3 border-b border-dashed py-4">
                <div class="w-1/3">
                    <span class="b">Urls</span>
                </div>
                <div class="w-full flex flex-col md:justify-between">
                    <tags-input :data-tags="{{ json_encode($audit->urls) }}" :required="true"
                                type="url" name="urls[]" placeholder="Add url ..."></tags-input>
                </div>
            </div>

            <div class="flex mt-3 border-b border-dashed py-4">
                <div class="w-1/3">
                    <span class="b">Audits</span>
                </div>
                <div class="w-full flex flex-col md:justify-between">
                    <label class="pr-2 pb-2 md:pb-0">
                        <input type="checkbox" name="audits[]"
                               value="accessibility" {{ old('accessibility', $audit->accessibility) ? 'checked': '' }}>
                        Accessibility
                    </label>
                    <label class="pr-2 pb-2 md:pb-0">
                        <input type="checkbox" name="audits[]"
                               value="best_practices" {{ old('best_practices', $audit->best_practices) ? 'checked': '' }}>
                        Best Practices
                    </label>
                    <label class="pr-2 pb-2 md:pb-0">
                        <input type="checkbox" name="audits[]"
                               value="performance" {{ old('performance', $audit->performance) ? 'checked': '' }}>
                        Performance
                    </label>
                    <label class="pr-2 pb-2 md:pb-0">
                        <input type="checkbox" name="audits[]"
                               value="pwa" {{ old('pwa', $audit->pwa) ? 'checked': '' }}> P.W.A
                    </label>
                    <label class="pr-2 pb-2 md:pb-0">
                        <input type="checkbox" name="audits[]"
                               value="seo" {{ old('seo', $audit->seo) ? 'checked': '' }}> SEO
                    </label>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center mt-3 border-b border-dashed py-4">
                <label class="w-1/3 b mb-2 md:mb-0" for="timeout">Timeout:</label>
                <input type="number" name="timeout" id="timeout" class="input"
                       min="1" value="{{ old('timeout', $audit->timeout) }}" required>
            </div>

            <div class="flex mt-3 border-b border-dashed py-4">
                <div class="w-1/3">
                    <span class="b">Headers</span>
                    <p class="mt-0">Any extra headers to be send in requests</p>
                </div>
                <div class="w-full ">
                    <headers-editor :data-headers="{{ json_encode($audit->headers) }}"></headers-editor>
                </div>
            </div>

            <div class="flex mt-3 border-b border-dashed py-4">
                <div class="w-1/3">
                    <span class="b">Webhook</span>
                </div>
                <div class="w-full ">
                    <label class="pr-2 pb-2 md:pb-0">
                        <input type="checkbox" name="webhook_enabled"
                               value="seo" {{ old('seo', $audit->webhook_enabled) ? 'checked': '' }}> Enable
                    </label>

                    <div class="flex flex-col md:flex-row md:items-center mt-3">
                        <label class="w-1/3 b mb-2 md:mb-0" for="webhook_branch">Branch:</label>
                        <input type="text" name="webhook_branch" id="webhook_branch" class="input"
                               value="{{ old('webhook_branch', $audit->webhook_branch) }}" required>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center mt-3">
                        <label class="w-1/3 b mb-2 md:mb-0" for="webhook_delay">Delay:</label>
                        <input type="number" name="webhook_delay" id="webhook_delay" class="input"
                               min="0" value="{{ old('webhook_delay', $audit->webhook_delay) }}" required>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center mt-3">
                        <label class="w-1/3-ns b mb-2 md:mb-0">Webhook url:</label>
                        <input type="text" class="input bn bg-transparent" disabled value="{{ route('webhooks', $audit) }}">
                    </div>
                </div>
            </div>

            <div class="flex mt-3 border-b border-dashed py-4">
                <div class="w-1/3">
                    <span class="b">Notifications</span>
                </div>
                <div class="w-full flex flex-col md:justify-between">
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
    <a class="p-2 mb-2 bg-gray-400 hover:bg-gray-500" href="{{ route('audits.show', $audit) }}">
        {{ $audit->name }}
    </a>
    <form action="{{ route('runs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="audit" value="{{ $audit->id }}">
        <button class="fab-button fab-button--secondary">Run now</button>
    </form>
@endpush
