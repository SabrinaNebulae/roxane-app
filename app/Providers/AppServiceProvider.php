<?php

namespace App\Providers;

use App\Listeners\PreprodMailInterceptor;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Event::listen(MessageSending::class, PreprodMailInterceptor::class);

        // Log failed jobs
        Queue::failing(function (JobFailed $event) {
            Log::error('Job failed: '.$event->job->resolveName(), [
                'exception' => $event->exception->getMessage(),
                'trace' => $event->exception->getTraceAsString(),
            ]);
        });
    }
}
