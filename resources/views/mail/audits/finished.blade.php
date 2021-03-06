@component('mail::message')
A new audit for <b>{{ $audit->name }}</b> was generated!

A total of <b>{{ $totalReports }}</b> urls were checked, <b>{{ $successfulReports }}</b> were successful and
<b>{{ $failedReports }}</b> failed to generate a report.

@component('mail::table')
    | Audit          | Score         |
    | -------------- |:-------------:|
    | Performance    | {{ $run->performance_score ?? '-' }}  |
    | P.W.A          | {{ $run->pwa_score ?? '-' }} |
    | Accessibility  | {{ $run->accessibility_score ?? '-' }} |
    | Best practices | {{ $run->best_practices_score ?? '-' }} |
    | S.E.O	         | {{ $run->seo_score ?? '-' }} |
@endcomponent

@component('mail::button', ['url' => route('runs.show', $run)])
    Full report
@endcomponent

@endcomponent
