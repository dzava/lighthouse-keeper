@extends('layouts.app')

@section('content')
    <div class="container mw7">
        <form action="{{ route('audits.store') }}" method="POST" class="bg-white pa3 mt3">
            @csrf
            <input type="text" class="input"
                   placeholder="Name"
                   name="name" required>

            <textarea name="urls" class="input" required
                      placeholder="Urls" rows="10"></textarea>

            <div class="flex flex-wrap items-center justify-between-ns pa3 ba b--light-gray">
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="audits[]" value="accessibility" checked> Accessibility
                </label>
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="audits[]" value="best_practices" checked> Best Practices
                </label>
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="audits[]" value="performance" checked> Performance
                </label>
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="audits[]" value="pwa"> P.W.A
                </label>
                <label class="pr2 pb2 pb0-ns">
                    <input type="checkbox" name="audits[]" value="seo" checked> SEO
                </label>
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
