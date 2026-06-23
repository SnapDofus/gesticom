<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Material;

class MaterialPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Material $material): bool
    {
        return $user->id === $material->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Material $material): bool
    {
        return $user->id === $material->user_id;
    }

    public function delete(User $user, Material $material): bool
    {
        return $user->id === $material->user_id;
    }
}
