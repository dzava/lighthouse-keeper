@extends('layouts.app')

@section('content')
    <div class="container mx-auto">

        <div class="flex items-center mt-2 pt-3 px-3">
            <div>
                <div
                    class="px-3 text-gray-700">{{ $audit->runCount }} {{ \Illuminate\Support\Str::plural('run', $audit->runCount) }}
                    for
                </div>
                <div class="px-3 text-2xl break-all">{{ $audit->name }}</div>
            </div>

            <div class="ml-auto">
                <form action="{{ route('runs.store') }}" method="POST" class="inline mr-3">
                    @csrf
                    <input type="hidden" name="audit" value="{{ $audit->id }}">
                    <button class="p-2 mb-2 bg-white hover:bg-gray-100">Run</button>
                </form>

                <a class="inline-block p-2 mb-2 rounded hover:bg-gray-100"
                   href="{{ route('audits.edit', $audit) }}">
                    Edit
                </a>
            </div>

        </div>

        <div class="mt-3 md:px-3 py-3 h5 bg-white">
            <chart :labels="{{ json_encode($chart->labels) }}" :datasets="{{ json_encode($chart->datasets) }}"></chart>
        </div>

        <div class="mt-3 bg-white">

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
                    <tr>
                        <td data-label="Date">{{ $run->created_at }}</td>
                        <td data-label="Performance" class="leading-loose relative">
                            @include('_gauge', ['percentage' => $run->performance_score, 'class' => 'w-8 h-8', 'change' => $run->performance_score_change])
                        </td>
                        <td data-label="P.W.A" class="leading-loose relative">
                            @include('_gauge', ['percentage' => $run->pwa_score, 'class' => 'w-8 h-8', 'change' => $run->pwa_score_change])
                        </td>
                        <td data-label="Accessibility" class="leading-loose relative">
                            @include('_gauge', ['percentage' => $run->accessibility_score, 'class' => 'w-8 h-8', 'change' => $run->accessibility_score_change])
                        </td>
                        <td data-label="Best practices" class="nowrap leading-loose relative">
                            @include('_gauge', ['percentage' => $run->best_practices_score, 'class' => 'w-8 h-8', 'change' => $run->best_practices_score_change])
                        </td>
                        <td data-label="S.E.O" class="leading-loose relative">
                            @include('_gauge', ['percentage' => $run->seo_score, 'class' => 'w-8 h-8', 'change' => $run->seo_score_change])
                        </td>

                        <td class="mt-4 nowrap">
                            <a href="{{ route('runs.show', $run) }}">View reports ({{ $run->reportCount }})</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

