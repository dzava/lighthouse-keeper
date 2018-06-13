@extends('layouts.app')

@section('content')
    <div class="container mw7">
        <div class="mt2 pt3 ph3 f3">
            Create a new audit
        </div>

        <form action="{{ route('audits.store') }}" method="POST" class="bg-white pa3 mt3">
            @csrf
            <div class="flex flex-column flex-row-ns items-center-ns">
                <label class="w-30 b mb2 mb0-ns" for="name">Name:</label>
                <input type="text" class="input"
                       placeholder="Name" value="{{ old('name') }}"
                       name="name" id="name" required>
            </div>

            <div class="flex mt3">
                <div class="w-30">
                    <span class="b">Urls</span>
                </div>
                <div class="w-100 flex flex-column justify-between-ns">
                    <tags-input type="url" name="urls[]" placeholder="Add url ..."></tags-input>
                </div>
            </div>

            <div class="flex mt3">
                <div class="w-30">
                    <span class="b">Audits</span>
                </div>
                <div class="w-100 flex flex-column justify-between-ns">
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]" value="accessibility" checked>
                        Accessibility
                    </label>
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]" value="best_practices" checked>
                        Best Practices
                    </label>
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]" value="performance" checked>
                        Performance
                    </label>
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]" value="pwa" > P.W.A
                    </label>
                    <label class="pr2 pb2 pb0-ns">
                        <input type="checkbox" name="audits[]" value="seo" checked> SEO
                    </label>
                </div>
            </div>

            <div class="tr">
                <button class="button">
                    Create
                </button>
                <a href="{{ route('audits') }}" class="link ml3">Cancel</a>
            </div>
        </form>
    </div>
@stop
