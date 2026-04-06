<?php

namespace App\Filament\Pages;

use App\Jobs\RunSyncCommand;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class Synchronisations extends Page
{
    protected string $view = 'filament.pages.synchronisations';

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-arrow-path';

    protected static string|null|\UnitEnum $navigationGroup = 'Paramètres';

    protected static ?int $navigationSort = 10;

    private const array CACHE_KEYS = [
        'dolibarr',
        'cleanup_expired',
        'ispconfig_mail',
        'ispconfig_web',
        'nextcloud',
        'services',
    ];

    public static function getNavigationLabel(): string
    {
        return __('synchronisations.navigation_label');
    }

    public function getTitle(): string
    {
        return __('synchronisations.title');
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public function getCommandStatus(string $key): array
    {
        return Cache::get("sync_run.{$key}", [
            'status' => 'idle',
            'output' => null,
            'started_at' => null,
            'finished_at' => null,
        ]);
    }

    public function hasRunningCommands(): bool
    {
        foreach (self::CACHE_KEYS as $key) {
            if (in_array($this->getCommandStatus($key)['status'], ['pending', 'running'])) {
                return true;
            }
        }

        return false;
    }

    private function enqueueCommand(string $key, string $command, array $parameters = []): void
    {
        Cache::put("sync_run.{$key}", [
            'status' => 'pending',
            'output' => null,
            'started_at' => null,
            'finished_at' => null,
        ], now()->addHour());

        RunSyncCommand::dispatch($command, $parameters, $key);
    }

    public function syncDolibarrAction(): Action
    {
        return Action::make('syncDolibarr')
            ->requiresConfirmation()
            ->modalHeading(__('synchronisations.sections.dolibarr.modal_heading'))
            ->modalDescription(__('synchronisations.sections.dolibarr.modal_description'))
            ->modalSubmitActionLabel(__('synchronisations.action.submit'))
            ->disabled(fn () => in_array($this->getCommandStatus('dolibarr')['status'], ['pending', 'running']))
            ->action(fn () => $this->enqueueCommand('dolibarr', 'sync:dolibarr-members'));
    }

    public function cleanupExpiredAction(): Action
    {
        return Action::make('cleanupExpired')
            ->modalHeading(__('synchronisations.sections.expired.modal_heading'))
            ->modalDescription(__('synchronisations.sections.expired.modal_description'))
            ->modalSubmitActionLabel(__('synchronisations.action.submit'))
            ->schema([
                Toggle::make('dry_run')
                    ->label(__('synchronisations.sections.expired.dry_run_label'))
                    ->helperText(__('synchronisations.sections.expired.dry_run_helper'))
                    ->default(true),
            ])
            ->disabled(fn () => in_array($this->getCommandStatus('cleanup_expired')['status'], ['pending', 'running']))
            ->action(function (array $data): void {
                $parameters = $data['dry_run'] ? ['--dry-run' => true] : [];
                $this->enqueueCommand('cleanup_expired', 'members:cleanup-expired', $parameters);
            });
    }

    public function syncISPConfigMailAction(): Action
    {
        return Action::make('syncISPConfigMail')
            ->requiresConfirmation()
            ->modalHeading(__('synchronisations.sections.ispconfig_mail.modal_heading'))
            ->modalDescription(__('synchronisations.sections.ispconfig_mail.modal_description'))
            ->modalSubmitActionLabel(__('synchronisations.action.submit'))
            ->disabled(fn () => in_array($this->getCommandStatus('ispconfig_mail')['status'], ['pending', 'running']))
            ->action(fn () => $this->enqueueCommand('ispconfig_mail', 'sync:ispconfig-mail-members'));
    }

    public function syncISPConfigWebAction(): Action
    {
        return Action::make('syncISPConfigWeb')
            ->modalHeading(__('synchronisations.sections.ispconfig_web.modal_heading'))
            ->modalDescription(__('synchronisations.sections.ispconfig_web.modal_description'))
            ->modalSubmitActionLabel(__('synchronisations.action.submit'))
            ->schema([
                Toggle::make('refresh_cache')
                    ->label(__('synchronisations.sections.ispconfig_web.refresh_cache_label'))
                    ->helperText(__('synchronisations.sections.ispconfig_web.refresh_cache_helper'))
                    ->default(false),
            ])
            ->disabled(fn () => in_array($this->getCommandStatus('ispconfig_web')['status'], ['pending', 'running']))
            ->action(function (array $data): void {
                $parameters = $data['refresh_cache'] ? ['--refresh-cache' => true] : [];
                $this->enqueueCommand('ispconfig_web', 'sync:ispconfig-web-members', $parameters);
            });
    }

    public function syncNextcloudAction(): Action
    {
        return Action::make('syncNextcloud')
            ->modalHeading(__('synchronisations.sections.nextcloud.modal_heading'))
            ->modalDescription(__('synchronisations.sections.nextcloud.modal_description'))
            ->modalSubmitActionLabel(__('synchronisations.action.submit'))
            ->schema([
                Toggle::make('dry_run')
                    ->label(__('synchronisations.sections.nextcloud.dry_run_label'))
                    ->helperText(__('synchronisations.sections.nextcloud.dry_run_helper'))
                    ->default(false),
            ])
            ->disabled(fn () => in_array($this->getCommandStatus('nextcloud')['status'], ['pending', 'running']))
            ->action(function (array $data): void {
                $parameters = $data['dry_run'] ? ['--dry-run' => true] : [];
                $this->enqueueCommand('nextcloud', 'nextcloud:sync-members', $parameters);
            });
    }

    public function syncServicesAction(): Action
    {
        return Action::make('syncServices')
            ->requiresConfirmation()
            ->modalHeading(__('synchronisations.sections.services.modal_heading'))
            ->modalDescription(__('synchronisations.sections.services.modal_description'))
            ->modalSubmitActionLabel(__('synchronisations.action.submit'))
            ->disabled(fn () => in_array($this->getCommandStatus('services')['status'], ['pending', 'running']))
            ->action(fn () => $this->enqueueCommand('services', 'memberships:sync-services'));
    }
}
