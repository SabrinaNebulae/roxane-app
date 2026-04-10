<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Output\Output;

class CacheLineOutput extends Output
{
    public function __construct(private readonly string $cacheKey)
    {
        parent::__construct(self::VERBOSITY_NORMAL);
    }

    protected function doWrite(string $message, bool $newline): void
    {
        $current = Cache::get($this->cacheKey, []);
        $clean = preg_replace('/\x1b\[[0-9;]*m/', '', $message);
        $current['output'] = ($current['output'] ?? '').$clean.($newline ? "\n" : '');
        Cache::put($this->cacheKey, $current, now()->addHour());
    }
}
