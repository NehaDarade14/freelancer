<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactInfoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view the contact info
     */
    public function view(User $currentUser, User $targetUser)
    {
        // Only allow viewing contact info if:
        // 1. Users have an active project together
        // 2. Or the current user is admin
        return $currentUser->projects()
            ->whereHas('users', function($query) use ($targetUser) {
                $query->where('users.id', $targetUser->id);
            })
            ->exists() || $currentUser->is_admin;
    }
}