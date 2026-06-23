<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProjectPhoto;

class ProjectPhotoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ProjectPhoto $photo): bool
    {
        return $user->id === $photo->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ProjectPhoto $photo): bool
    {
        return $user->id === $photo->user_id;
    }

    public function delete(User $user, ProjectPhoto $photo): bool
    {
        return $user->id === $photo->user_id;
    }
}
