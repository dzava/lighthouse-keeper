<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Audit audit
 * @property string json_report
 * @property string html_report
 * @property bool failure_reason
 */
class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @param string $reason
     * @return bool
     */
    public function markAsFailed($reason)
    {
        return $this->update([
            'failure_reason' => $reason,
        ]);
    }

    /**
     * Check if the report is marked as failed
     *
     * @return bool
     */
    public function failed()
    {
        return $this->failure_reason !== null;
    }

    /**
     * The Audit this report belongs to
     *
     * @return Audit
     */
    public function getAuditAttribute()
    {
        return $this->run->audit;
    }

    public function getPerformanceScoreChangeAttribute()
    {
        return $this->change($this->previousReport, 'performance_score');
    }

    public function getPwaScoreChangeAttribute()
    {
        return $this->change($this->previousReport, 'pwa_score');
    }

    public function getAccessibilityScoreChangeAttribute()
    {
        return $this->change($this->previousReport, 'accessibility_score');
    }

    public function getBestPracticesScoreChangeAttribute()
    {
        return $this->change($this->previousReport, 'best_practices_score');
    }

    public function getSeoScoreChangeAttribute()
    {
        return $this->change($this->previousReport, 'seo_score');
    }

    public function previousReport()
    {
        $previousRuns = $this->audit->runs()->where('id', '<', $this->run_id)->select('id');

        return $this->hasOne(Report::class, 'url', 'url')
            ->whereIn('run_id', $previousRuns)
            ->whereNull('failure_reason')
            ->latest();
    }

    /**
     * The Run this report belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function run()
    {
        return $this->belongsTo(Run::class);
    }

    protected function change($otherReport, $category)
    {
        if (is_null($otherReport)) {
            return null;
        }

        if (is_null($this->$category) || is_null($otherReport->$category)) {
            return null;
        }

        return $this->$category - $otherReport->$category;
    }
}
