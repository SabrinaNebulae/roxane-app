@if($status['status'] === 'pending')
    <p class="text-sm text-warning-600 dark:text-warning-400">En attente dans la file d'exécution...</p>
@elseif($status['status'] === 'running')
    <p class="text-sm text-primary-600 dark:text-primary-400">Exécution en cours...</p>
@elseif(in_array($status['status'], ['completed', 'failed']) && $status['output'])
    <div class="rounded-lg bg-gray-50 p-2 dark:bg-gray-900">
        <pre class="max-h-28 overflow-auto whitespace-pre-wrap text-xs {{ $status['status'] === 'failed' ? 'text-danger-600' : 'text-gray-700 dark:text-gray-300' }}">{{ $status['output'] }}</pre>
    </div>
    @if($status['finished_at'])
        <p class="text-xs text-gray-400">Terminé à {{ $status['finished_at'] }}</p>
    @endif
@endif
