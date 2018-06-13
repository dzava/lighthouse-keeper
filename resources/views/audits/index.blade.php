@extends('layouts.app')

@section('content')
    <div class="mt4-ns container bg-white ph3-ns">

        <table class="table">
            <thead>
            <tr>
                <th>Audit</th>
                <th>Last run</th>
            </tr>
            </thead>
            <tbody>
            @foreach($audits as $audit)
                <tr class="tc pa3">
                    <td class="tl break-all">
                        <a href="{{ route('audits.show', $audit) }}" class="link break-all">{{ $audit->name }}</a>
                    </td>
                    <td data-label="Last run" class="nowrap">
                        @if($audit->latestRun)
                            <a href="{{ route('runs.show', $audit->latestRun) }}"
                               class="link break-all">{{ $audit->latestRun->created_at }}</a>
                        @else
                            Never
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
