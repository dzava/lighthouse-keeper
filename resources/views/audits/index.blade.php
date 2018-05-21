@extends('layouts.app')

@section('content')
    <div class="mt4-ns container bg-white ph3-ns">

        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Last run</th>
                <th>Audits</th>
            </tr>
            </thead>
            <tbody>
            @foreach($audits as $audit)
                <tr class="tc pa3">
                    <td class="tl break-all">{{ $audit->name }}</td>
                    <td data-label="Last run" class="nowrap">{{ $audit->latestRun->created_at }}</td>
                    <td data-label="Audits" class="nowrap">
                        <a href="{{ route('audits.show', $audit) }}" class="link break-all">Show</a>
                        ({{ $audit->runCount }})
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
