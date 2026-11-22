@if($status['status'] === 'pending')
    <p class="text-sm text-warning-600 dark:text-warning-400">{{ __('synchronisations.status.pending') }}</p>
@elseif($status['status'] === 'running')
    <p class="text-sm text-primary-600 dark:text-primary-400">{{ __('synchronisations.status.running') }}</p>
@elseif(in_array($status['status'], ['completed', 'failed']) && $status['output'])
    <div class="rounded-lg bg-gray-50 p-2 dark:bg-gray-900">
        <pre
            class="max-h-28 overflow-auto whitespace-pre-wrap text-xs {{ $status['status'] === 'failed' ? 'text-danger-600' : 'text-gray-700 dark:text-gray-300' }}"
            x-data
            x-init="
                $el.scrollTop = $el.scrollHeight;
                const observer = new MutationObserver(() => {
                    $el.scrollTop = $el.scrollHeight;
                });
                observer.observe($el, { childList: true, characterData: true, subtree: true });
            "
        >{{ $status['output'] }}</pre>
    </div>
    @if($status['finished_at'])
        <p class="text-xs text-gray-400">{{ __('synchronisations.status.finished_at', ['time' => $status['finished_at']]) }}</p>
    @endif
@endif
