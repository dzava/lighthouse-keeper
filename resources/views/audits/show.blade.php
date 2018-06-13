@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="mt2 pt3 ph3">
            <div class="ph3 black-70">{{ $audit->runCount }} {{ str_plural('run', $audit->runCount) }} for</div>
            <div class="ph3 f3 break-all">{{ $audit->name }}</div>
        </div>

        <div class="mt3 pa3 h5 bg-white">
            <chart :labels="{{ json_encode($chart->labels) }}" :datasets="{{ json_encode($chart->datasets) }}"></chart>
        </div>

        <div class="mt3 bg-white">

            <table class="table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Performance</th>
                    <th>P.W.A</th>
                    <th>Accessibility</th>
                    <th>Best practices</th>
                    <th>S.E.O</th>
                    <th>Reports</th>
                </tr>
                </thead>
                <tbody>
                @foreach($audit->runs as $run)
                    <tr class="pa3">
                        <td data-label="Date">{{ $run->created_at }}</td>
                        <td data-label="Performance" class="lh2">
                            @include('_gauge', ['percentage' => $run->performance_score, 'class' => 'w2 h2'])
                        </td>
                        <td data-label="P.W.A" class="lh2">
                            @include('_gauge', ['percentage' => $run->pwa_score, 'class' => 'w2 h2'])
                        </td>
                        <td data-label="Accessibility" class="lh2">
                            @include('_gauge', ['percentage' => $run->accessibility_score, 'class' => 'w2 h2'])
                        </td>
                        <td data-label="Best practices" class="nowrap lh2">
                            @include('_gauge', ['percentage' => $run->best_practices_score, 'class' => 'w2 h2'])
                        </td>
                        <td data-label="S.E.O" class="lh2">
                            @include('_gauge', ['percentage' => $run->seo_score, 'class' => 'w2 h2'])
                        </td>

                        <td class="mt2 nowrap">
                            <a href="{{ route('runs.show', $run) }}">View reports</a> ({{ $run->reportCount }})
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@push('fab-start')
    <a class="fab-button fab-button--secondary" href="{{ route('audits.edit', $audit) }}">
        Edit
    </a>
    <form action="{{ route('runs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="audit" value="{{ $audit->id }}">
        <button class="fab-button fab-button--secondary">Run now</button>
    </form>
@endpush
