<x-filament-panels::page>
    <div
        class="grid grid-cols-1 sm:grid-cols-2"
        style="gap: 1.5rem"
        @if($this->hasRunningCommands()) wire:poll.5s @endif
    >
        @php
            $dolibarr  = $this->getCommandStatus('dolibarr');
            $expired   = $this->getCommandStatus('cleanup_expired');
            $ispMail   = $this->getCommandStatus('ispconfig_mail');
            $ispWeb    = $this->getCommandStatus('ispconfig_web');
            $nextcloud = $this->getCommandStatus('nextcloud');
            $listmonk  = $this->getCommandStatus('listmonk');
            $services  = $this->getCommandStatus('services');
        @endphp

        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', [
                    'label' => __('synchronisations.sections.dolibarr.heading'),
                    'status' => $dolibarr,
                ])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('synchronisations.sections.dolibarr.description') }}
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $dolibarr])
                <x-filament::button
                    wire:click="mountAction('syncDolibarr')"
                    :disabled="in_array($dolibarr['status'], ['pending', 'running'])"
                >
                    {{ __('synchronisations.action.submit') }}
                </x-filament::button>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', [
                    'label' => __('synchronisations.sections.expired.heading'),
                    'status' => $expired,
                ])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('synchronisations.sections.expired.description') }}
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $expired])
                <x-filament::button
                    wire:click="mountAction('cleanupExpired')"
                    :disabled="in_array($expired['status'], ['pending', 'running'])"
                >
                    {{ __('synchronisations.action.submit') }}
                </x-filament::button>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', [
                    'label' => __('synchronisations.sections.ispconfig_mail.heading'),
                    'status' => $ispMail,
                ])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('synchronisations.sections.ispconfig_mail.description') }}
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $ispMail])
                <x-filament::button
                    wire:click="mountAction('syncISPConfigMail')"
                    :disabled="in_array($ispMail['status'], ['pending', 'running'])"
                >
                    {{ __('synchronisations.action.submit') }}
                </x-filament::button>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', [
                    'label' => __('synchronisations.sections.ispconfig_web.heading'),
                    'status' => $ispWeb,
                ])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('synchronisations.sections.ispconfig_web.description') }}
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $ispWeb])
                <x-filament::button
                    wire:click="mountAction('syncISPConfigWeb')"
                    :disabled="in_array($ispWeb['status'], ['pending', 'running'])"
                >
                    {{ __('synchronisations.action.submit') }}
                </x-filament::button>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', [
                    'label' => __('synchronisations.sections.nextcloud.heading'),
                    'status' => $nextcloud,
                ])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('synchronisations.sections.nextcloud.description') }}
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $nextcloud])
                <x-filament::button
                    wire:click="mountAction('syncNextcloud')"
                    :disabled="in_array($nextcloud['status'], ['pending', 'running'])"
                >
                    {{ __('synchronisations.action.submit') }}
                </x-filament::button>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', [
                    'label' => __('synchronisations.sections.listmonk.heading'),
                    'status' => $listmonk,
                ])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('synchronisations.sections.listmonk.description') }}
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $listmonk])
                <x-filament::button
                    wire:click="mountAction('syncListmonk')"
                    :disabled="in_array($listmonk['status'], ['pending', 'running'])"
                >
                    {{ __('synchronisations.action.submit') }}
                </x-filament::button>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                @include('filament.pages.partials.sync-heading', [
                    'label' => __('synchronisations.sections.services.heading'),
                    'status' => $services,
                ])
            </x-slot>
            <div class="space-y-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('synchronisations.sections.services.description') }}
                </p>
                @include('filament.pages.partials.sync-status', ['status' => $services])
                <x-filament::button
                    wire:click="mountAction('syncServices')"
                    :disabled="in_array($services['status'], ['pending', 'running'])"
                >
                    {{ __('synchronisations.action.submit') }}
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
