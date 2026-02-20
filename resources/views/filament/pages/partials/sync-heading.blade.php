<span class="flex items-center gap-2">
    {{ $label }}
    @if(in_array($status['status'], ['pending', 'running']))
        <x-filament::loading-indicator class="h-4 w-4 text-primary-500" />
    @elseif($status['status'] === 'completed')
        <x-filament::icon icon="heroicon-o-check-circle" class="h-4 w-4 text-success-500" />
    @elseif($status['status'] === 'failed')
        <x-filament::icon icon="heroicon-o-x-circle" class="h-4 w-4 text-danger-500" />
    @endif
</span>
