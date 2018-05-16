<?php

namespace App\Listeners;

use App\Events\ReportCreatedEvent;
use App\Report;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ProcessReport
{
    /** @var Report */
    protected $report;

    /**
     * Handle the event.
     *
     * @param  ReportCreatedEvent $event
     * @return void
     */
    public function handle(ReportCreatedEvent $event)
    {
        $report = $this->report = $event->report;

        if ($report->failed()) {
            return;
        }

        if (!is_readable($report->json_report)) {
            $report->markAsFailed('Report was not generated or is not readable');

            return;
        }

        $report->update(array_merge(
            $this->getScores(),
            $this->relocateReports()
        ));
    }

    /**
     * Get the score for each category in the report
     *
     * @return array
     */
    protected function getScores()
    {
        $json = json_decode(file_get_contents($this->report->json_report), JSON_OBJECT_AS_ARRAY);

        return collect($json['reportCategories'])->flatMap(function ($category) {
            $id = str_replace('-', '_', $category['id']);
            $value = (int)ceil($category['score']);

            return ["{$id}_score" => $value];
        })->toArray();
    }

    protected function relocateReports()
    {
        return [
            'json_report' => $this->moveAndDeleteReport($this->report->json_report),
            'html_report' => $this->moveAndDeleteReport($this->report->html_report),
        ];
    }

    protected function moveAndDeleteReport($reportPath)
    {
        $path = 'audits/' . $this->report->audit->id . '/reports';

        $path = Storage::disk('public')
            ->putFileAs($path, new File($reportPath), basename($reportPath));

        if ($path) {
            unlink($reportPath);
        }

        return $path;
    }
}
