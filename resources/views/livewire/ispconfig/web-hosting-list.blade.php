<div class="space-y-4">
    @forelse ($websites as $hosting)
        @php
            $data = $hosting->data ?? [];
        @endphp

        <div class="border rounded-lg p-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <strong>Domaine</strong><br>
                    {{ $data['domain'] ?? '—' }}
                </div>

                <div>
                    <strong>État</strong><br>
                    {{ ($data['active'] ?? 'n') === 'o' ? 'Activé' : 'Désactivé' }}
                </div>

                <div class="col-span-2">
                    <strong>Document root</strong><br>
                    {{ $data['document_root'] ?? '—' }}
                </div>
            </div>

            {{-- Bases de données --}}
            @if (!empty($data['databases']))
                <details class="mt-4">
                    <summary class="cursor-pointer font-medium">
                        Bases de données ({{ count($data['databases']) }})
                    </summary>

                    <ul class="list-disc ml-6 mt-2">
                        @foreach ($data['databases'] as $db)
                            <li>
                                {{ $db['database_name'] ?? '—' }}
                                ({{ $db['database_type'] ?? '—' }})
                            </li>
                        @endforeach
                    </ul>
                </details>
            @endif

            {{-- Accès shell --}}
            @if (!empty($data['shell_users']))
                <details class="mt-4">
                    <summary class="cursor-pointer font-medium">
                        Accès shell ({{ count($data['shell_users']) }})
                    </summary>

                    <ul class="list-disc ml-6 mt-2">
                        @foreach ($data['shell_users'] as $user)
                            <li>
                                {{ $user['username'] ?? '—' }}
                                ({{ $user['shell'] ?? '—' }})
                            </li>
                        @endforeach
                    </ul>
                </details>
            @endif

            {{-- DNS --}}
            @if (!empty($data['dns_zones']))
                <details class="mt-4">
                    <summary class="cursor-pointer font-medium">
                        Zones DNS ({{ count($data['dns_zones']) }})
                    </summary>

                    <ul class="list-disc ml-6 mt-2">
                        @foreach ($data['dns_zones'] as $zone)
                            <li>
                                {{ $zone['origin'] ?? '—' }}
                                – {{ $zone['ns'] ?? '—' }}
                            </li>
                        @endforeach
                    </ul>
                </details>
            @endif
        </div>
    @empty
        <p class="text-sm text-gray-500">
            Aucun hébergement web.
        </p>
    @endforelse
</div>
