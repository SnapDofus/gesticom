<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkerPayment;

class WorkerPaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, WorkerPayment $payment): bool
    {
        return $user->id === $payment->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, WorkerPayment $payment): bool
    {
        return $user->id === $payment->user_id;
    }

    public function delete(User $user, WorkerPayment $payment): bool
    {
        return $user->id === $payment->user_id;
    }
}
