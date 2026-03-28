<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DbExportTest extends TestCase
{
    use RefreshDatabase;

    public function testExportSkipsEmptyTable(): void
    {
        /** @var \Illuminate\Testing\PendingCommand $command */
        $command = $this->artisan('db:export', ['--tables' => 'elspotprices', '--no-interaction' => true]);
        $command->assertExitCode(0)
            ->expectsOutputToContain('Skipping elspotprices');
    }

    public function testExportHandlesInvalidTableGracefully(): void
    {
        /** @var \Illuminate\Testing\PendingCommand $command */
        $command = $this->artisan('db:export', ['--tables' => 'nonexistent_table', '--no-interaction' => true]);
        $command->assertExitCode(1);
    }
}
