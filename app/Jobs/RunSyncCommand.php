<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Output\BufferedOutput;

class RunSyncCommand implements ShouldQueue
{
    use Queueable;

    public int $timeout = 600;

    public function __construct(
        public readonly string $command,
        public readonly array $parameters,
        public readonly string $cacheKey,
    ) {}

    public function handle(): void
    {
        $startedAt = now()->toDateTimeString();

        Cache::put("sync_run.{$this->cacheKey}", [
            'status' => 'running',
            'output' => null,
            'started_at' => $startedAt,
            'finished_at' => null,
        ], now()->addHour());

        try {
            $buffer = new BufferedOutput(BufferedOutput::VERBOSITY_NORMAL, false);
            Artisan::call($this->command, $this->parameters, $buffer);
            $output = trim(preg_replace('/\x1b\[[0-9;]*m/', '', $buffer->fetch()));

            Cache::put("sync_run.{$this->cacheKey}", [
                'status' => 'completed',
                'output' => $output,
                'started_at' => $startedAt,
                'finished_at' => now()->toDateTimeString(),
            ], now()->addDay());
        } catch (\Throwable $e) {
            Cache::put("sync_run.{$this->cacheKey}", [
                'status' => 'failed',
                'output' => $e->getMessage(),
                'started_at' => $startedAt,
                'finished_at' => now()->toDateTimeString(),
            ], now()->addDay());
        }
    }

    public function failed(\Throwable $exception): void
    {
        Cache::put("sync_run.{$this->cacheKey}", [
            'status' => 'failed',
            'output' => $exception->getMessage(),
            'started_at' => null,
            'finished_at' => now()->toDateTimeString(),
        ], now()->addDay());
    }
}
