<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string url
 * @property bool accessibility
 * @property bool best_practices
 * @property bool performance
 * @property bool pwa
 * @property bool seo
 * @property mixed headers
 * @property mixed timeout
 */
class Audit extends Model
{
    protected $availableAudits = ['accessibility', 'best_practices', 'performance', 'pwa', 'seo'];

    protected $guarded = [];

    protected $casts = [
        'accessibility' => 'bool',
        'best_practices' => 'bool',
        'performance' => 'bool',
        'pwa' => 'bool',
        'seo' => 'bool',
        'headers' => 'array',
    ];

    public function getUrlsAttribute($value)
    {
        return collect(explode("\n", $value));
    }

    public function getUrlsAsStringAttribute()
    {
        return implode("\n", $this->urls->toArray());
    }

    public function getRunCountAttribute()
    {
        return $this->runs()->count();
    }

    public function setAuditsAttribute($value)
    {
        foreach ($this->availableAudits as $audit) {
            $this->$audit = in_array($audit, $value);
        }
    }

    public function latestRun()
    {
        return $this->hasOne(Run::class)->latest();
    }

    public function runs()
    {
        return $this->hasMany(Run::class)->latest();
    }
}
