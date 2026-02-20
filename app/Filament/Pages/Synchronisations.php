<?php

namespace App\Filament\Pages;

use App\Jobs\RunSyncCommand;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use UnitEnum;

class Synchronisations extends Page
{
    protected string $view = 'filament.pages.synchronisations';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path';

    protected static string|UnitEnum|null $navigationGroup = 'Paramètres';

    protected static ?string $navigationLabel = 'Synchronisations';

    protected static ?string $title = 'Synchronisations';

    protected static ?string $slug = 'synchronisations';

    protected static ?int $navigationSort = 10;

    private const array CACHE_KEYS = [
        'dolibarr',
        'cleanup_expired',
        'ispconfig_mail',
        'ispconfig_web',
        'nextcloud',
        'services',
    ];

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
            ->label('Lancer')
            ->requiresConfirmation()
            ->modalHeading('Synchronisation Dolibarr')
            ->modalDescription('Importer les membres et cotisations depuis Dolibarr.')
            ->modalSubmitActionLabel('Lancer')
            ->disabled(fn () => in_array($this->getCommandStatus('dolibarr')['status'], ['pending', 'running']))
            ->action(fn () => $this->enqueueCommand('dolibarr', 'sync:dolibarr-members'));
    }

    public function cleanupExpiredAction(): Action
    {
        return Action::make('cleanupExpired')
            ->label('Lancer')
            ->modalHeading('Désactiver les membres expirés')
            ->modalDescription('Désactive les membres expirés dans Dolibarr, ISPConfig et Nextcloud.')
            ->modalSubmitActionLabel('Lancer')
            ->schema([
                Toggle::make('dry_run')
                    ->label('Mode simulation (dry-run)')
                    ->helperText('Simule l\'opération sans effectuer de modifications.')
                    ->default(true),
            ])
            ->disabled(fn () => in_array($this->getCommandStatus('cleanup_expired')['status'], ['pending', 'running']))
            ->action(function (array $data) {
                $parameters = $data['dry_run'] ? ['--dry-run' => true] : [];
                $this->enqueueCommand('cleanup_expired', 'members:cleanup-expired', $parameters);
            });
    }

    public function syncISPConfigMailAction(): Action
    {
        return Action::make('syncISPConfigMail')
            ->label('Lancer')
            ->requiresConfirmation()
            ->modalHeading('Synchronisation ISPConfig Mail')
            ->modalDescription('Lie les membres à leurs comptes mail ISPConfig (@retzien.fr).')
            ->modalSubmitActionLabel('Lancer')
            ->disabled(fn () => in_array($this->getCommandStatus('ispconfig_mail')['status'], ['pending', 'running']))
            ->action(fn () => $this->enqueueCommand('ispconfig_mail', 'sync:ispconfig-mail-members'));
    }

    public function syncISPConfigWebAction(): Action
    {
        return Action::make('syncISPConfigWeb')
            ->label('Lancer')
            ->modalHeading('Synchronisation ISPConfig Web')
            ->modalDescription('Lie les membres à leurs comptes d\'hébergement web.')
            ->modalSubmitActionLabel('Lancer')
            ->schema([
                Toggle::make('refresh_cache')
                    ->label('Vider le cache ISPConfig')
                    ->helperText('Vide le cache avant la synchronisation.')
                    ->default(false),
            ])
            ->disabled(fn () => in_array($this->getCommandStatus('ispconfig_web')['status'], ['pending', 'running']))
            ->action(function (array $data) {
                $parameters = $data['refresh_cache'] ? ['--refresh-cache' => true] : [];
                $this->enqueueCommand('ispconfig_web', 'sync:ispconfig-web-members', $parameters);
            });
    }

    public function syncNextcloudAction(): Action
    {
        return Action::make('syncNextcloud')
            ->label('Lancer')
            ->modalHeading('Synchronisation Nextcloud')
            ->modalDescription('Lie les membres à leurs comptes Nextcloud.')
            ->modalSubmitActionLabel('Lancer')
            ->schema([
                Toggle::make('dry_run')
                    ->label('Mode simulation (dry-run)')
                    ->helperText('Simule l\'opération sans effectuer de modifications.')
                    ->default(false),
            ])
            ->disabled(fn () => in_array($this->getCommandStatus('nextcloud')['status'], ['pending', 'running']))
            ->action(function (array $data) {
                $parameters = $data['dry_run'] ? ['--dry-run' => true] : [];
                $this->enqueueCommand('nextcloud', 'nextcloud:sync-members', $parameters);
            });
    }

    public function syncServicesAction(): Action
    {
        return Action::make('syncServices')
            ->label('Lancer')
            ->requiresConfirmation()
            ->modalHeading('Synchronisation des services')
            ->modalDescription('Synchronise les services associés aux membres actifs.')
            ->modalSubmitActionLabel('Lancer')
            ->disabled(fn () => in_array($this->getCommandStatus('services')['status'], ['pending', 'running']))
            ->action(fn () => $this->enqueueCommand('services', 'memberships:sync-services'));
    }
}
