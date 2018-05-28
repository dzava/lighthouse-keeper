<?php

namespace App;

use Illuminate\Support\Collection;

class Chart
{
    protected $records;
    protected $datasetsMap;
    protected $labelField;
    protected $labelCallback;

    /**
     * @param Collection $records
     */
    public function __construct($records)
    {
        $this->records = $records;
        $this->labelField = 'created_at';
        $this->labelCallback = function ($date) {
            return $date->format('Y-m-d H:m');
        };
        $this->datasetsMap = [
            'Accessibility' => 'accessibility_score',
            'Best Practices' => 'best_practices_score',
            'Performance' => 'performance_score',
            'P.W.A' => 'pwa_score',
            'S.E.O' => 'seo_score',
        ];
    }

    /**
     * @return Collection
     */
    public function datasets()
    {
        return collect($this->datasetsMap)->map(function ($field, $label) {
            return [
                'label' => $label,
                'data' => $this->records->pluck($field)->toArray(),
            ];
        })->values();
    }

    /**
     * @return Collection
     */
    public function labels()
    {
        $labels = $this->records->pluck($this->labelField);

        if (is_callable($this->labelCallback)) {
            $labels = $labels->map($this->labelCallback);
        }

        return $labels;
    }

    public function __get($field)
    {
        return call_user_func([$this, $field]);
    }
}
