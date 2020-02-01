<?php

namespace Tests\Unit\Auditing;

use App\Audit;
use App\Auditing\LighthouseAuditor;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Illuminate\Support\Arr;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Tests\TestCase;

/**
 * @group Integration
 */
class LighthouseAuditorTest extends TestCase
{
    use AuditorTests, ArraySubsetAsserts;

    /** @test */
    public function is_configured_from_an_audit()
    {
        $audit = Audit::factory()->make(['pwa' => false, 'best_practices' => false]);

        [$jsonReport, $htmlReport] = $this->getAuditor()->configureForAudit($audit)->audit($audit->urls[0]);

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
        $audit = Audit::factory()->make([
            'headers' => [
                ['name' => 'Cookie', 'value' => 'monster'],
                ['name' => 'Empty', 'value' => null],
                ['name' => 'Number-Zero', 'value' => 0],
                ['name' => 'With spaces', 'value' => 'and more spaces'],
            ],
        ]);

        [$jsonReport, $htmlReport] = $this->getAuditor()->configureForAudit($audit)->audit($audit->urls[0]);

        $this->assertFileExists($jsonReport);

        $headers = $this->getHeadersInReport($jsonReport);
        $this->assertArraySubset(['Cookie' => 'monster'], $headers);
        $this->assertArraySubset(['Empty' => ''], $headers);
        $this->assertArraySubset(['Number-Zero' => 0], $headers);
        $this->assertArraySubset(['With-spaces' => 'and more spaces'], $headers);
    }

    /** @test */
    public function timeout_is_correctly_set()
    {
        $this->expectException(ProcessTimedOutException::class);

        $audit = Audit::factory()->make(['timeout' => 1]);

        $this->getAuditor()->configureForAudit($audit)->audit($audit->urls[0]);
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
        }, $jsonReport['categories']);

        sort($categories);

        return $categories;
    }

    public function getHeadersInReport($path)
    {
        $report = json_decode(file_get_contents($path), true);

        return Arr::get($report, 'configSettings.extraHeaders');
    }
}
