@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt2 pt3 ph3 relative">
            <div class="ph3 black-50">{{ $run->reportCount }} {{ str_plural('report', $run->reportCount) }} for</div>
            <div class="ph3 f3 break-all">{{ $run->audit->url }}</div>
            <div class="ph3 black-50">on {{ $run->created_at }}</div>
        </div>

        <div class="mt3 bg-white">
            <table class="table">
                <thead>
                <tr>
                    <th class="wrap-all">Url</th>
                    <th>Performance</th>
                    <th>P.W.A</th>
                    <th>Accessibility</th>
                    <th>Best practices</th>
                    <th>S.E.O</th>
                    <th>Reports</th>
                </tr>
                </thead>
                <tbody>

                @foreach($run->reports as $report)
                    <tr class="pa3">
                        <td class="break-all" data-label="Url">
                            <a class="link" href="{{ $report->url }}">{{ $report->url }}</a>
                        </td>
                        @if($report->failed())
                            <td colspan="6" class="tl dark-red b" title="{{ $report->failure_reason }}">
                                {{ str_limit($report->failure_reason) }}
                            </td>
                        @else
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
                            <td class="nowrap">
                                <a href="{{ route('reports.show', $report) }}" class="link">
                                    Open report
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
