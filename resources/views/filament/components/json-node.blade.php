@php
    $isArray = is_array($value);

    $isAssoc = $isArray && array_keys($value) !== range(0, count($value) - 1);

    $displayType = $isArray
        ? ($isAssoc ? 'object' : 'array')
        : gettype($value);

    $preview = $isArray
        ? ($isAssoc ? '{…}' : '[…]')
        : (is_bool($value) ? ($value ? 'true' : 'false') : (is_null($value) ? 'null' : (string) $value));
@endphp

<div class="font-mono text-sm leading-6">
    @if ($isArray)
        <div x-data="{ open: false }" class="ml-2">
            <button type="button" class="text-gray-700 dark:text-gray-200 hover:underline" @click="open = !open">
                <span x-text="open ? '▾' : '▸'"></span>
                <span class="text-gray-500 dark:text-gray-400">{{ $displayType }}</span>
                <span class="text-gray-400 dark:text-gray-500">({{ count($value) }})</span>
                <span class="text-gray-400 dark:text-gray-500" x-show="!open">{{ $preview }}</span>
            </button>

            <div x-show="open" x-cloak class="mt-1 border-l border-gray-200 dark:border-gray-800 pl-3">
                @foreach ($value as $k => $v)
                    <div class="flex gap-2">
                        <div class="shrink-0 text-indigo-700 dark:text-indigo-300">
                            {{ $isAssoc ? '"' . $k . '"' : $k }}
                            <span class="text-gray-400 dark:text-gray-500">:</span>
                        </div>

                        <div class="min-w-0">
                            @include('filament.components.json-node', [
                                'value' => $v,
                                'path' => ($path === '' ? (string) $k : ($path . '.' . $k)),
                            ])
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <span class="text-emerald-700 dark:text-emerald-300">
            @if (is_string($value))
                "{{ $value }}"
            @elseif (is_bool($value))
                {{ $value ? 'true' : 'false' }}
            @elseif (is_null($value))
                null
            @else
                {{ $value }}
            @endif
        </span>
    @endif
</div>
