<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\Notifications\AdminInvitationNotification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Generate a random password if none was provided, so the invitation
     * flow can proceed without requiring the admin to set one manually.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['password'])) {
            $data['password'] = Str::random(32);
        }

        return $data;
    }

    /**
     * Send an invitation email after the user is created so they can
     * set their own password via the admin panel reset flow.
     */
    protected function afterCreate(): void
    {
        /** @var User $user */
        $user = $this->record;
        $token = Password::broker()->createToken($user);

        $user->notify(new AdminInvitationNotification($token));
        Log::info('User invited: '.$user->email);
    }
}
