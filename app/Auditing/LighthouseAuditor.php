<?php

namespace App\Auditing;

use Dzava\Lighthouse\Lighthouse;

class LighthouseAuditor implements Auditor
{
    /** @var Lighthouse */
    private $lighthouse;

    /**
     * @param Lighthouse $lighthouse
     */
    public function __construct(Lighthouse $lighthouse)
    {
        $this->lighthouse = $lighthouse;
    }

    public function configureForAudit($audit)
    {
        $this->lighthouse
            ->accessibility($audit->accessibility)
            ->bestPractices($audit->best_practices)
            ->performance($audit->performance)
            ->pwa($audit->pwa)
            ->seo($audit->seo)
            ->setHeaders($this->formatHeaders($audit->headers))
            ->setTimeout($audit->timeout);

        return $this;
    }

    /**
     * @param string $url
     * @return array
     * @throws \Dzava\Lighthouse\Exceptions\AuditFailedException
     */
    public function audit($url)
    {
        $path = $this->getOutputPath();

        $this->lighthouse
            ->setOutput($path, ['json', 'html'])
            ->audit($url);

        return ["$path.report.json", "$path.report.html"];
    }

    /**
     * @return string
     */
    protected function getOutputPath()
    {
        $path = sys_get_temp_dir() . "/reports/";

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        return uniqid($path);
    }

    private function formatHeaders($headers)
    {
        return collect($headers)->flatMap(function ($header) {
            $name = dash_case(array_get($header, 'name'));
            $value = array_get($header, 'value');

            if (empty($value)) {
                $value = '';
            }

            return [$name => $value];
        })->toArray();
    }
}
