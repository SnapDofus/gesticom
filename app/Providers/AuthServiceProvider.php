<?php

namespace App\Providers;

use App\Models\Material;
use App\Models\Expense;
use App\Models\Worker;
use App\Models\WorkerPayment;
use App\Models\Task;
use App\Models\ProjectPhoto;
use App\Models\Budget;
use App\Models\Notification;
use App\Policies\MaterialPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\WorkerPolicy;
use App\Policies\WorkerPaymentPolicy;
use App\Policies\TaskPolicy;
use App\Policies\ProjectPhotoPolicy;
use App\Policies\BudgetPolicy;
use App\Policies\NotificationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Material::class => MaterialPolicy::class,
        Expense::class => ExpensePolicy::class,
        Worker::class => WorkerPolicy::class,
        WorkerPayment::class => WorkerPaymentPolicy::class,
        Task::class => TaskPolicy::class,
        ProjectPhoto::class => ProjectPhotoPolicy::class,
        Budget::class => BudgetPolicy::class,
        Notification::class => NotificationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
