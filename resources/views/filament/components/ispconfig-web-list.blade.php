<div class="space-y-4">
    @foreach($ispconfigs as $ispconfig)
        <div class="border rounded-lg p-4 bg-white dark:bg-gray-800">
            <div class="flex items-start justify-between mb-3">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $ispconfig->data['domain'] ?? 'Domaine non défini' }}
                </h4>
                <div>
                    <a
                        href="#"
                        target="_blank"
                        class="inline-flex items-center gap-1 text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium"
                    >
                        Gérer dans ISPConfig

                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 text-sm">
                @foreach($ispconfig->data as $key => $value)
                    @if(!is_array($value) && !is_null($value))
                        <div class="flex flex-col">
                            <span class="text-gray-500 dark:text-gray-400 text-xs">
                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                            </span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $value }}
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</div>
