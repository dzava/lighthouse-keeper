<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Audit audit
 * @property string json_report
 * @property string html_report
 * @property bool failure_reason
 */
class Report extends Model
{
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

    /**
     * The Run this report belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function run()
    {
        return $this->belongsTo(Run::class);
    }
}
