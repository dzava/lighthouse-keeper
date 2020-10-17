@extends('layouts.app')

@section('content')
    <div class="container mx-auto mw7">
        <div class="mt2 pt3 ph3 text-2xl">
            Create a new audit
        </div>

        <form action="{{ route('audits.store') }}" method="POST" class="bg-white p-3 mt-3">
            @csrf
            <div class="flex flex-col md:flex-row md:items-center border-b border-dashed py-4">
                <label class="w-1/3 md:mb-2 mb-0" for="name">Name:</label>
                <input type="text" class="input"
                       placeholder="Name" value="{{ old('name') }}"
                       name="name" id="name" required>
            </div>

            <div class="flex mt-3 border-b border-dashed py-4">
                <div class="w-1/3">
                    <span class="b">Urls</span>
                </div>
                <div class="w-full flex flex-col md:justify-between">
                    <tags-input type="url" name="urls[]" placeholder="Add url ..." :required="true"></tags-input>
                </div>
            </div>

            <div class="flex mt-3 border-b border-dashed py-4">
                <div class="w-1/3">
                    <span class="b">Audits</span>
                </div>
                <div class="w-full flex flex-col md:justify-between">
                    <label class="pr-2 pb-2 md:pb0">
                        <input type="checkbox" name="audits[]" value="accessibility" checked>
                        Accessibility
                    </label>
                    <label class="pr-2 pb-2 md:pb0">
                        <input type="checkbox" name="audits[]" value="best_practices" checked>
                        Best Practices
                    </label>
                    <label class="pr-2 pb-2 md:pb0">
                        <input type="checkbox" name="audits[]" value="performance" checked>
                        Performance
                    </label>
                    <label class="pr-2 pb-2 md:pb0">
                        <input type="checkbox" name="audits[]" value="pwa"> P.W.A
                    </label>
                    <label class="pr-2 pb-2 md:pb0">
                        <input type="checkbox" name="audits[]" value="seo" checked> SEO
                    </label>
                </div>
            </div>

            <div class="text-right">
                <label class="pr-2 pb-2 md:pb0">
                    <input type="checkbox" name="run_immediately" class="mr-2"> Schedule audit to run immediately
                </label>

                <button class="button">
                    Create
                </button>
                <a href="{{ route('audits') }}" class="ml-3">Cancel</a>
            </div>
        </form>
    </div>
@stop
