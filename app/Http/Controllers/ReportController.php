<?php

namespace App\Http\Controllers;

use App\Exports\ExpensesExport;
use App\Exports\MaterialsExport;
use App\Exports\PaymentsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Expense;
use App\Models\Material;
use App\Models\Task;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function financial()
    {
        $userId = Auth::id();
        $expenses = Expense::where('user_id', $userId)->get();
        $budgets = Budget::where('user_id', $userId)->get();
        $totalSpent = $expenses->sum('amount');
        $totalBudget = $budgets->where('category', 'global')->first()->planned_amount ?? 0;

        $pdf = Pdf::loadView('reports.financial-pdf', compact('expenses', 'budgets', 'totalSpent', 'totalBudget'));
        return $pdf->download('rapport-financier.pdf');
    }

    public function materials()
    {
        $userId = Auth::id();
        $materials = Material::where('user_id', $userId)->get();

        $pdf = Pdf::loadView('reports.materials-pdf', compact('materials'));
        return $pdf->download('rapport-materiaux.pdf');
    }

    public function tasks()
    {
        $userId = Auth::id();
        $tasks = Task::where('user_id', $userId)->get();

        $pdf = Pdf::loadView('reports.tasks-pdf', compact('tasks'));
        return $pdf->download('rapport-chantier.pdf');
    }

    public function expensesExcel()
    {
        return (new ExpensesExport)->download('depenses.xlsx');
    }

    public function materialsExcel()
    {
        return (new MaterialsExport)->download('materiaux.xlsx');
    }

    public function paymentsExcel()
    {
        return (new PaymentsExport)->download('paiements.xlsx');
    }
}
