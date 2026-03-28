<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DbExportTest extends TestCase
{
    use RefreshDatabase;

    private string $testFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testFile = database_path('fixtures/poweruse-users.csv');
        // Back up existing fixture if present
        if (file_exists($this->testFile)) {
            copy($this->testFile, $this->testFile . '.bak');
        }
    }

    protected function tearDown(): void
    {
        // Restore original fixture
        if (file_exists($this->testFile . '.bak')) {
            rename($this->testFile . '.bak', $this->testFile);
        }
        parent::tearDown();
    }

    public function testExportCreatesFixtureFile(): void
    {
        User::factory()->count(2)->create();

        $this->artisan('db:export', ['--tables' => 'users', '--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileExists($this->testFile);
        $content = file_get_contents($this->testFile);
        $lines = array_filter(explode("\n", $content));
        $this->assertCount(2, $lines);
    }

    public function testExportSkipsEmptyTable(): void
    {
        $this->artisan('db:export', ['--tables' => 'elspotprices', '--no-interaction' => true])
            ->assertExitCode(0)
            ->expectsOutputToContain('Skipping elspotprices');
    }
}
