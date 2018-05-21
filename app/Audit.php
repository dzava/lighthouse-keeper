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
 */
class Audit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'accessibility' => 'bool',
        'best_practices' => 'bool',
        'performance' => 'bool',
        'pwa' => 'bool',
        'seo' => 'bool',
    ];

    public function getUrlsAttribute($value)
    {
        return collect(explode("\n", $value));
    }

    public function getRunCountAttribute()
    {
        return $this->runs()->count();
    }

    public function getLatestRunAttribute()
    {
        return $this->runs()->latest()->first();
    }

    public function runs()
    {
        return $this->hasMany(Run::class)->latest();
    }
}
