<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed audit
 */
class Run extends Model
{
    protected $guarded = [];

    protected $aggregates = [];

    /**
     * @param $audit
     * @return self
     */
    public static function forAudit($audit)
    {
        return static::create([
            'audit_id' => $audit->id,
        ]);
    }

    /**
     * @param string $url
     * @param string $jsonReportPath
     * @param string $htmlReportPath
     * @return Report
     */
    public function addReport($url, $jsonReportPath, $htmlReportPath)
    {
        return $this->reports()->create([
            'url' => $url,
            'json_report' => $jsonReportPath,
            'html_report' => $htmlReportPath,
        ]);
    }

    /**
     * @param string $url
     * @param string $reason
     * @return Report
     */
    public function addFailedReport($url, $reason)
    {
        return $this->reports()->create([
            'url' => $url,
            'failure_reason' => $reason,
        ]);
    }

    public function getReportCountAttribute()
    {
        return $this->reports()->count();
    }

    public function getLatestReportAttribute()
    {
        return $this->reports()->latest()->first();
    }

    /**
     * The Audit this run belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function audit()
    {
        return $this->belongsTo(Audit::class);
    }

    /**
     * The Reports for this run
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function failedReports()
    {
        return $this->reports()->whereNotNull('failure_reason');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function successfulReports()
    {
        return $this->reports()->whereNull('failure_reason');
    }
}
