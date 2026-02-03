<div class="fi-stack">
    @forelse ($websites as $hosting)
        @php
            $data = $hosting->data ?? [];
        @endphp

        <x-filament::section>
            <x-slot name="heading">
                {{ $data['domain'] ?? 'Domaine inconnu' }}
            </x-slot>

            {{-- Informations principales --}}
            <div class="fi-infolist">
                <div class="fi-infolist-item">
                    <div class="fi-infolist-label">Domaine</div>
                    <div class="fi-infolist-text">
                        {{ $data['domain'] ?? '—' }}
                    </div>
                </div>

                <div class="fi-infolist-item">
                    <div class="fi-infolist-label">État</div>
                    <div class="fi-infolist-text">
                        {{ ($data['active'] ?? 'n') === 'o' ? 'Activé' : 'Désactivé' }}
                    </div>
                </div>

                <div class="fi-infolist-item">
                    <div class="fi-infolist-label">Document root</div>
                    <div class="fi-infolist-text">
                        {{ $data['document_root'] ?? '—' }}
                    </div>
                </div>
            </div>

            {{-- Bases de données --}}
            @if (!empty($data['databases']))
                <x-filament::section collapsible collapsed>
                    <x-slot name="heading">
                        Bases de données ({{ count($data['databases']) }})
                    </x-slot>

                    <div class="fi-infolist">
                        @foreach ($data['databases'] as $db)
                            <div class="fi-infolist-item">
                                {{ $db['database_name'] ?? '—' }}
                                ({{ $db['database_type'] ?? '—' }})
                            </div>
                        @endforeach
                    </div>
                </x-filament::section>
            @endif

            {{-- Accès shell --}}
            @if (!empty($data['shell_users']))
                <x-filament::section collapsible collapsed>
                    <x-slot name="heading">
                        Accès shell ({{ count($data['shell_users']) }})
                    </x-slot>

                    <div class="fi-infolist">
                        @foreach ($data['shell_users'] as $user)
                            <div class="fi-infolist-item">
                                {{ $user['username'] ?? '—' }}
                                ({{ $user['shell'] ?? '—' }})
                            </div>
                        @endforeach
                    </div>
                </x-filament::section>
            @endif

            {{-- DNS --}}
            @if (!empty($data['dns_zones']))
                <x-filament::section collapsible collapsed>
                    <x-slot name="heading">
                        Zones DNS ({{ count($data['dns_zones']) }})
                    </x-slot>

                    <div class="fi-infolist">
                        @foreach ($data['dns_zones'] as $zone)
                            <div class="fi-infolist-item">
                                {{ $zone['origin'] ?? '—' }} – {{ $zone['ns'] ?? '—' }}
                            </div>
                        @endforeach
                    </div>
                </x-filament::section>
            @endif
        </x-filament::section>
    @empty
        <x-filament::section>
            <div class="fi-infolist-text">
                Aucun hébergement web.
            </div>
        </x-filament::section>
    @endforelse
</div>
