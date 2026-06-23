<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Budget;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())->latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('receipt')) {
            $data['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }

        $expense = Expense::create($data);

        $budget = Budget::where('user_id', Auth::id())->where('category', $data['category'])->first();
        if ($budget) {
            $budget->increment('spent_amount', $data['amount']);
        }

        $globalBudget = Budget::where('user_id', Auth::id())->where('category', 'global')->first();
        if ($globalBudget) {
            $globalBudget->increment('spent_amount', $data['amount']);
        }

        $this->checkBudgetAlerts($expense);

        return redirect()->route('expenses.index')->with('success', 'Dépense ajoutée avec succès.');
    }

    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        return response()->json($expense);
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $data = $request->validated();

        if ($request->hasFile('receipt')) {
            if ($expense->receipt) {
                Storage::disk('public')->delete($expense->receipt);
            }
            $data['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }

        $expense->update($data);

        return redirect()->route('expenses.index')->with('success', 'Dépense modifiée avec succès.');
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);

        if ($expense->receipt) {
            Storage::disk('public')->delete($expense->receipt);
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Dépense supprimée avec succès.');
    }

    public function chartData()
    {
        $userId = Auth::id();

        $byMonth = Expense::where('user_id', $userId)
            ->selectRaw("strftime('%Y-%m', date) as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $byCategory = Expense::where('user_id', $userId)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        return response()->json(compact('byMonth', 'byCategory'));
    }

    private function checkBudgetAlerts($expense)
    {
        $budget = Budget::where('user_id', Auth::id())->where('category', $expense->category)->first();
        if ($budget && $budget->planned_amount > 0) {
            $progress = ($budget->spent_amount / $budget->planned_amount) * 100;
            if ($progress >= 100) {
                NotificationController::create([
                    'type' => 'budget_over',
                    'title' => 'Budget dépassé',
                    'message' => "Le budget {$expense->category} a été dépassé.",
                ]);
            } elseif ($progress >= 90) {
                NotificationController::create([
                    'type' => 'budget_warning',
                    'title' => 'Budget presque atteint',
                    'message' => "Le budget {$expense->category} est utilisé à {$progress}%.",
                ]);
            }
        }
    }
}
