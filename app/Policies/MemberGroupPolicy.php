<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MemberGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberGroupPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MemberGroup');
    }

    public function view(AuthUser $authUser, MemberGroup $memberGroup): bool
    {
        return $authUser->can('View:MemberGroup');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MemberGroup');
    }

    public function update(AuthUser $authUser, MemberGroup $memberGroup): bool
    {
        return $authUser->can('Update:MemberGroup');
    }

    public function delete(AuthUser $authUser, MemberGroup $memberGroup): bool
    {
        return $authUser->can('Delete:MemberGroup');
    }

    public function restore(AuthUser $authUser, MemberGroup $memberGroup): bool
    {
        return $authUser->can('Restore:MemberGroup');
    }

    public function forceDelete(AuthUser $authUser, MemberGroup $memberGroup): bool
    {
        return $authUser->can('ForceDelete:MemberGroup');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MemberGroup');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MemberGroup');
    }

    public function replicate(AuthUser $authUser, MemberGroup $memberGroup): bool
    {
        return $authUser->can('Replicate:MemberGroup');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MemberGroup');
    }

}