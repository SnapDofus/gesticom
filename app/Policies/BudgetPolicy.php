<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Budget;

class BudgetPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Budget $budget): bool
    {
        return $user->id === $budget->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Budget $budget): bool
    {
        return $user->id === $budget->user_id;
    }

    public function delete(User $user, Budget $budget): bool
    {
        return $user->id === $budget->user_id;
    }
}
