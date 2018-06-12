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
            <input type="text" class="input"
                   placeholder="Name" value="{{ old('name', $audit->name) }}"
                   name="name" required>

            <textarea name="urls" class="input" required
                      placeholder="Urls" rows="10">{{ old('urls', $audit->urlsAsString) }}</textarea>

            <div class="flex pa3 ba b--light-gray">
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

            <div class="mt4 pa3 ba b--light-gray">
                <div class="flex flex-column flex-row-ns items-center-ns">
                    <label class="w-30 b mb2 mb0-ns" for="timeout">Timeout:</label>
                    <input type="number" name="timeout" id="timeout" class="input"
                           min="1" value="{{ old('timeout', $audit->timeout) }}" required>
                </div>
            </div>

            <div class="flex mt4 pa3 ba b--light-gray">
                <div class="w-30">
                    <span class="b">Headers</span>
                    <p>Any extra headers to be send in requests</p>
                </div>
                <div class="w-100 ">
                    <headers-editor :data-headers="{{ json_encode($audit->headers) }}"></headers-editor>
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
