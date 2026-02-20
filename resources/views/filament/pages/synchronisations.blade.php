@vite('resources/css/backend.css')

<x-filament-panels::page>
    <div
        class="grid grid-cols-1 gap-4 sm:grid-cols-2"
        @if($this->hasRunningCommands()) wire:poll.5s @endif
    >
        @php
            $dolibarr     = $this->getCommandStatus('dolibarr');
            $expired      = $this->getCommandStatus('cleanup_expired');
            $ispMail      = $this->getCommandStatus('ispconfig_mail');
            $ispWeb       = $this->getCommandStatus('ispconfig_web');
            $nextcloud    = $this->getCommandStatus('nextcloud');
            $services     = $this->getCommandStatus('services');
        @endphp

        {{-- Dolibarr --}}
        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', ['label' => 'Dolibarr', 'status' => $dolibarr])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Importe les membres et cotisations depuis Dolibarr.
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $dolibarr])

                {{ $this->getAction('syncDolibarr') }}
            </div>
        </x-filament::section>

        {{-- Membres expirés --}}
        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', ['label' => 'Membres expirés', 'status' => $expired])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Désactive les membres expirés dans Dolibarr, ISPConfig et Nextcloud.
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $expired])

                {{ $this->getAction('cleanupExpired') }}
            </div>
        </x-filament::section>

        {{-- ISPConfig Mail --}}
        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', ['label' => 'ISPConfig Mail', 'status' => $ispMail])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lie les membres à leurs comptes mail ISPConfig (@retzien.fr).
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $ispMail])

                {{ $this->getAction('syncISPConfigMail') }}
            </div>
        </x-filament::section>

        {{-- ISPConfig Web --}}
        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', ['label' => 'ISPConfig Web', 'status' => $ispWeb])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lie les membres à leurs comptes d'hébergement web.
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $ispWeb])

                {{ $this->getAction('syncISPConfigWeb') }}
            </div>
        </x-filament::section>

        {{-- Nextcloud --}}
        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', ['label' => 'Nextcloud', 'status' => $nextcloud])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lie les membres à leurs comptes Nextcloud.
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $nextcloud])

                {{ $this->getAction('syncNextcloud') }}
            </div>
        </x-filament::section>

        {{-- Services membres --}}
        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', ['label' => 'Services membres', 'status' => $services])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Synchronise les services associés aux membres actifs.
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $services])

                {{ $this->getAction('syncServices') }}
            </div>
        </x-filament::section>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
