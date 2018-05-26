@extends('layouts.app')

@section('content')
    <div class="container mw7">
        <form action="{{ route('audits.store') }}" method="POST" class="bg-white pa3 mt3">
            @csrf
            <input type="text" class="input"
                   placeholder="Name this audit"
                   name="name" required>

            <textarea name="urls" class="input"
                      placeholder="Urls to audit (one per line, absolute urls only)" rows="10"></textarea>

            <div class="flex flex-wrap items-center justify-between-ns pa3 ba b--light-gray">
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="accessibility" checked> Accessibility
                </label>
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="best_practices" checked> Best Practices
                </label>
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="performance" checked> Performance
                </label>
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="pwa"> P.W.A
                </label>
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="seo" checked> SEO
                </label>
            </div>

            <headers-editor class="mt4 pa3 ba b--light-gray"></headers-editor>

            <div class="tr">
                <button class="input-reset relative pa3 mt3 bg-white br1 ba b--black-20">
                    Create
                </button>
                <a href="{{ route('audits') }}" class="link ml3">Cancel</a>
            </div>
        </form>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
