@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex items-center mt-2 pt-3 px-3 mb-3">

            <div>
                <div
                    class="px-3 text-gray-700">{{ $run->reportCount }} {{ \Illuminate\Support\Str::plural('report', $run->reportCount) }}
                    for
                </div>
                <div class="px-3 text-2xl break-all">
                    <a href="{{ route('audits.show', $run->audit) }}" class="text-gray-900">{{ $run->audit->name }}</a>
                </div>
                <div class="px-3 text-gray-700">on {{ $run->created_at }}</div>
            </div>

            <div class="ml-auto">
                <form action="{{ route('runs.store') }}" method="POST" class="inline mr-3">
                    @csrf
                    <input type="hidden" name="audit" value="{{ $run->audit->id }}">
                    <button class="p-2 mb-2 bg-white hover:bg-gray-100">Run</button>
                </form>

                <a class="inline-block p-2 mb-2 rounded hover:bg-gray-100"
                   href="{{ route('audits.edit', $run->audit) }}">
                    Edit
                </a>
            </div>

        </div>

        @unless($run->successfulReports->isEmpty())
            <div class="bg-white border-t-4 border-green-700">
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
                        <tr>
                            <td class="break-all" data-label="Url">
                                <a class="link" href="{{ $report->url }}">{{ $report->url }}</a>
                            </td>
                            <td data-label="Performance" class="leading-loose">
                                @include('_gauge', ['percentage' => $report->performance_score, 'class' => 'w-8 h-8'])
                            </td>
                            <td data-label="P.W.A" class="leading-loose">
                                @include('_gauge', ['percentage' => $report->pwa_score, 'class' => 'w-8 h-8'])
                            </td>
                            <td data-label="Accessibility" class="leading-loose">
                                @include('_gauge', ['percentage' => $report->accessibility_score, 'class' => 'w-8 h-8'])
                            </td>
                            <td data-label="Best practices" class="nowrap leading-loose">
                                @include('_gauge', ['percentage' => $report->best_practices_score, 'class' => 'w-8 h-8'])
                            </td>
                            <td data-label="S.E.O" class="leading-loose">
                                @include('_gauge', ['percentage' => $report->seo_score, 'class' => 'w-8 h-8'])
                            </td>
                            <td class="nowrap">
                                <a href="{{ route('reports.show', $report) }}" class="">
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
            <div class="mt-16 bg-white border-t-4 border-red-700">

                <h2 class="p-2 text-center">Failed reports</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Url</th>
                        <th>Reason</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($run->failedReports as $report)
                        <tr>
                            <td data-label="Url">
                                <a class="" href="{{ $report->url }}">{{ $report->url }}</a>
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

