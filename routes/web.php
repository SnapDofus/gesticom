<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WorkerPaymentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectPhotoController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('materials')->name('materials.')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('index');
        Route::post('/', [MaterialController::class, 'store'])->name('store');
        Route::get('/{material}/edit', [MaterialController::class, 'edit'])->name('edit');
        Route::put('/{material}', [MaterialController::class, 'update'])->name('update');
        Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('destroy');
        Route::patch('/{material}/purchased', [MaterialController::class, 'markAsPurchased'])->name('purchased');
        Route::get('/stats', [MaterialController::class, 'stats'])->name('stats');
    });

    Route::prefix('expenses')->name('expenses.')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('index');
        Route::post('/', [ExpenseController::class, 'store'])->name('store');
        Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->name('edit');
        Route::put('/{expense}', [ExpenseController::class, 'update'])->name('update');
        Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
        Route::get('/chart-data', [ExpenseController::class, 'chartData'])->name('chart-data');
    });

    Route::prefix('workers')->name('workers.')->group(function () {
        Route::get('/', [WorkerController::class, 'index'])->name('index');
        Route::post('/', [WorkerController::class, 'store'])->name('store');
        Route::get('/{worker}/edit', [WorkerController::class, 'edit'])->name('edit');
        Route::put('/{worker}', [WorkerController::class, 'update'])->name('update');
        Route::delete('/{worker}', [WorkerController::class, 'destroy'])->name('destroy');
        Route::get('/{worker}/payments', [WorkerPaymentController::class, 'index'])->name('payments');
        Route::post('/{worker}/payments', [WorkerPaymentController::class, 'store'])->name('payments.store');
        Route::delete('/{worker}/payments/{payment}', [WorkerPaymentController::class, 'destroy'])->name('payments.destroy');
    });

    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        Route::patch('/{task}/progress', [TaskController::class, 'updateProgress'])->name('progress');
    });

    Route::prefix('photos')->name('photos.')->group(function () {
        Route::get('/', [ProjectPhotoController::class, 'index'])->name('index');
        Route::post('/', [ProjectPhotoController::class, 'store'])->name('store');
        Route::delete('/{photo}', [ProjectPhotoController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('budgets')->name('budgets.')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('index');
        Route::put('/{budget}', [BudgetController::class, 'update'])->name('update');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
        Route::get('/materials', [ReportController::class, 'materials'])->name('materials');
        Route::get('/tasks', [ReportController::class, 'tasks'])->name('tasks');
        Route::get('/expenses-excel', [ReportController::class, 'expensesExcel'])->name('expenses-excel');
        Route::get('/materials-excel', [ReportController::class, 'materialsExcel'])->name('materials-excel');
        Route::get('/payments-excel', [ReportController::class, 'paymentsExcel'])->name('payments-excel');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
