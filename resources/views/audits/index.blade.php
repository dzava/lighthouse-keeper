@extends('layouts.app')

@section('content')
    <div class="mt-4 container mx-auto bg-white md:px-3">

        <table class="table">
            <thead>
            <tr>
                <th>Audit</th>
                <th>Last run</th>
            </tr>
            </thead>
            <tbody>
            @foreach($audits as $audit)
                <tr class="p-3 text-center">
                    <td class="break-all">
                        <a href="{{ route('audits.show', $audit) }}" class="text-left break-all">{{ $audit->name }}</a>
                    </td>
                    <td data-label="Last run" class="">
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
