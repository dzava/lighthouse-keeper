@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt2 pt3 ph3 relative">
            <div class="ph3 black-50">{{ $run->reportCount }} {{ \Illuminate\Support\Str::plural('report', $run->reportCount) }} for</div>
            <div class="ph3 f3 break-all">
                <a href="{{ route('audits.show', $run->audit) }}" class="link black-90">{{ $run->audit->name }}</a>
            </div>
            <div class="ph3 black-50">on {{ $run->created_at }}</div>
        </div>

        @unless($run->successfulReports->isEmpty())
            <div class="mt3 bg-white bt bw2 b--dark-green">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="wrap-all">Url</th>
                        <th>Performance</th>
                        <th>P.W.A</th>
                        <th>Accessibility</th>
                        <th>Best practices</th>
                        <th>S.E.O</th>
                        <th>Report</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($run->successfulReports as $report)
                        <tr class="pa3">
                            <td class="break-all" data-label="Url">
                                <a class="link" href="{{ $report->url }}">{{ $report->url }}</a>
                            </td>
                            <td data-label="Performance" class="lh2">
                                @include('_gauge', ['percentage' => $report->performance_score, 'class' => 'w2 h2'])
                            </td>
                            <td data-label="P.W.A" class="lh2">
                                @include('_gauge', ['percentage' => $report->pwa_score, 'class' => 'w2 h2'])
                            </td>
                            <td data-label="Accessibility" class="lh2">
                                @include('_gauge', ['percentage' => $report->accessibility_score, 'class' => 'w2 h2'])
                            </td>
                            <td data-label="Best practices" class="nowrap lh2">
                                @include('_gauge', ['percentage' => $report->best_practices_score, 'class' => 'w2 h2'])
                            </td>
                            <td data-label="S.E.O" class="lh2">
                                @include('_gauge', ['percentage' => $report->seo_score, 'class' => 'w2 h2'])
                            </td>
                            <td class="nowrap">
                                <a href="{{ route('reports.show', $report) }}" class="link">
                                    Open
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endunless

        @unless($run->failedReports->isEmpty())
            <div class="mt5 bg-white bt bw2 b--dark-red">

                <h2 class="pa2 tc">Failed reports</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Url</th>
                        <th>Reason</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($run->failedReports as $report)
                        <tr class="pa3">
                            <td data-label="Url">
                                <a class="link" href="{{ $report->url }}">{{ $report->url }}</a>
                            </td>
                            <td data-label="Reason" class="break-all">
                                {{ $report->failure_reason }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endunless
    </div>
@stop

@push('fab-start')
    <a class="fab-button fab-button--secondary" href="{{ route('audits.show', $run->audit) }}">
        {{ $run->audit->name }}
    </a>
    <form action="{{ route('runs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="audit" value="{{ $run->audit->id }}">
        <button class="fab-button fab-button--secondary">Run now</button>
    </form>
@endpush
