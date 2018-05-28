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

            <div class="mt4 pa3 ba b--light-gray">
                <div class="flex flex-column flex-row-ns items-center-ns">
                    <label class="w-20 b mb2 mb0-ns" for="timeout">Timeout:</label>
                    <input type="number" name="timeout" id="timeout" class="input" placeholder="default: 60"
                           min="1">
                </div>
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
