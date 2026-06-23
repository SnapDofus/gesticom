<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Expense;
use App\Models\Task;
use App\Models\Worker;
use App\Models\Budget;
use App\Models\ProjectPhoto;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'totalBudget' => Budget::where('user_id', $userId)->where('category', 'global')->value('planned_amount') ?? 0,
            'totalSpent' => Expense::where('user_id', $userId)->sum('amount'),
            'materialCount' => Material::where('user_id', $userId)->count(),
            'purchasedMaterials' => Material::where('user_id', $userId)->whereIn('status', ['partially_purchased', 'fully_purchased'])->count(),
            'completedTasks' => Task::where('user_id', $userId)->where('status', 'completed')->count(),
            'totalTasks' => Task::where('user_id', $userId)->count(),
            'workerCount' => Worker::where('user_id', $userId)->count(),
            'photoCount' => ProjectPhoto::where('user_id', $userId)->count(),
        ];

        $remaining = $stats['totalBudget'] - $stats['totalSpent'];
        $stats['remainingBudget'] = max(0, $remaining);
        $stats['budgetProgress'] = $stats['totalBudget'] > 0 ? round(($stats['totalSpent'] / $stats['totalBudget']) * 100) : 0;

        $taskProgress = Task::where('user_id', $userId)->avg('progress') ?? 0;
        $stats['overallProgress'] = round($taskProgress);

        $recentExpenses = Expense::where('user_id', $userId)->latest()->take(5)->get();
        $recentMaterials = Material::where('user_id', $userId)->latest()->take(5)->get();
        $recentTasks = Task::where('user_id', $userId)->latest()->take(5)->get();
        $recentPhotos = ProjectPhoto::where('user_id', $userId)->latest()->take(5)->get();

        $dateField = DB::getDriverName() === 'mysql'
            ? "DATE_FORMAT(date, '%Y-%m')"
            : "strftime('%Y-%m', date)";

        $expensesByMonth = Expense::where('user_id', $userId)
            ->selectRaw("$dateField as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $expensesByCategory = Expense::where('user_id', $userId)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        $tasksProgress = Task::where('user_id', $userId)
            ->orderBy('stage')
            ->get(['name', 'progress']);

        $workers = Worker::with('payments')->where('user_id', $userId)->get()->map(function ($w) {
            return [
                'id' => $w->id,
                'full_name' => $w->full_name,
                'function' => $w->function,
                'daily_wage' => $w->daily_wage,
                'total_paid' => $w->total_paid,
            ];
        });

        return view('dashboard.index', compact(
            'stats',
            'recentExpenses',
            'recentMaterials',
            'recentTasks',
            'recentPhotos',
            'expensesByMonth',
            'expensesByCategory',
            'tasksProgress',
            'workers'
        ));
    }
}
