<?php

namespace Tests\Unit\Auditing;

use App\Audit;
use App\Auditing\LighthouseAuditor;
use Tests\TestCase;

/**
 * @group Integration
 */
class LighthouseAuditorTest extends TestCase
{
    use AuditorTests;

    /** @test */
    public function is_configured_from_an_audit()
    {
        $audit = factory(Audit::class)->make(['pwa' => false, 'best_practices' => false]);

        [$jsonReport, $htmlReport] = $this->getAuditor()->configureForAudit($audit)->audit($audit->urls->first());

        $this->assertFileExists($jsonReport);
        $this->assertFileExists($htmlReport);

        $categories = $this->getCategoriesInReport($jsonReport);

        $this->assertNotContains('pwa', $categories);
        $this->assertNotContains('best-practices', $categories);
        $this->assertArraySubset(['accessibility', 'performance', 'seo'], $categories);
    }

    /** @test */
    public function extra_headers_are_passed_to_lighthouse()
    {
        $audit = factory(Audit::class)->make([
            'headers' => [
                ['name' => 'Cookie', 'value' => 'monster'],
                ['name' => 'Empty', 'value' => null],
                ['name' => 'Number-Zero', 'value' => 0],
                ['name' => 'With spaces', 'value' => 'and more spaces'],
            ],
        ]);

        [$jsonReport, $htmlReport] = $this->getAuditor()->configureForAudit($audit)->audit($audit->urls->first());

        $this->assertFileExists($jsonReport);

        $headers = $this->getHeadersInReport($jsonReport);
        $this->assertArraySubset(['Cookie' => 'monster'], $headers);
        $this->assertArraySubset(['Empty' => ''], $headers);
        $this->assertArraySubset(['Number-Zero' => 0], $headers);
        $this->assertArraySubset(['With-spaces' => 'and more spaces'], $headers);
    }

    public function getAuditor(): LighthouseAuditor
    {
        return app(LighthouseAuditor::class);
    }

    public function getCategoriesInReport($path)
    {
        $jsonReport = json_decode(file_get_contents($path), true);

        $categories = array_map(function ($category) {
            return $category['id'];
        }, $jsonReport['reportCategories']);

        sort($categories);

        return $categories;
    }

    public function getHeadersInReport($path)
    {
        $report = json_decode(file_get_contents($path), true);

        return array_get($report, 'runtimeConfig.extraHeaders');
    }
}
